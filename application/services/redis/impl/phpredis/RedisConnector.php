<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 17/9/19
 * Time: 2:01 PM
 */

namespace AppServices\redis\impl\phpredis;

use AppServices\redis\contracts\IRedisConnector;
use Redis;

class RedisConnector implements IRedisConnector
{
    public function connect($config, $options)
    {
        $arr = [];
        if(isset($config['options'])){
            $arr = $config['options'];
            unset($config['options']);
        }
        return new RedisConnection($this->createClient(
            array_merge(
                $config,
                $options,
                $arr
            )
        ));
    }

    public function createClient(array $config)
    {
        return tap(new Redis, function (Redis $client) use ($config) {
            $this->establishConnection($client, $config);

            if (! empty($config['password'])) {
                $client->auth($config['password']);
            }

            if (! empty($config['database'])) {
                $client->select($config['database']);
            }

            if (! empty($config['prefix'])) {
                $client->setOption(Redis::OPT_PREFIX, $config['prefix']);
            }

            if (! empty($config['read_timeout'])) {
                $client->setOption(Redis::OPT_READ_TIMEOUT, $config['read_timeout']);
            }
        });
    }

    public function establishConnection($client, array $config)
    {
        $persistent = $config['persistent'] ?? false;

        $parameters = [
            $config['host'],
            $config['port'],
            $config['timeout'] ?? 0.0,
            $persistent ? ($config['persistent_id'] ?? null) : null,
            $config['retry_interval'] ?? 1,
        ];

        if (version_compare(phpversion('redis'), '3.1.3', '>=')) {
            $parameters[] = $config['read_timeout'] ?? 0.0;
        }

        $client->{($persistent ? 'pconnect' : 'connect')}(...$parameters);
    }
}