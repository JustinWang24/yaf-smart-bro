<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 17/9/19
 * Time: 12:41 PM
 */

namespace AppServices\redis\impl\phpredis;
use AppServices\redis\contracts\IRedisConnection;

class RedisConnection implements IRedisConnection
{
    /**
     * @var string $name
     */
    private $name;
    /**
     * @var \Redis $client
     */
    private $client;

    /**
     * RedisConnection constructor.
     * @param \Redis $client
     * @param string $name
     */
    public function __construct($client, $name = 'default')
    {
        $this->client = $client;
        $this->setName($name);
    }

    /**
     * Returns the value of the given key.
     *
     * @param  string  $key
     * @return string|null
     */
    public function get($key)
    {
        $result = $this->command('get', [$key]);
        return $result !== false ? $result : null;
    }

    /**
     * 一次性的根据多个给定的 keys 数组获取全部的数据
     *
     * @param  array  $keys
     * @return array
     */
    public function mget(array $keys)
    {
        return array_map(function ($value) {
            return $value !== false ? $value : null;
        }, $this->command('mget', [$keys]));
    }

    /**
     * Determine if the given keys exist.
     *
     * @param  mixed $keys
     * @return int
     */
    public function exists(...$keys)
    {
        return $this->executeRaw(array_merge(['exists'], $keys));
    }

    public function set($key, $value, $expireResolution = null, $expireTTL = null, $flag = null)
    {
        return $this->command('set', [
            $key,
            $value,
            $expireResolution ? [$flag, $expireResolution => $expireTTL] : null,
        ]);
    }

    public function setnx($key, $value)
    {
        return (int) $this->command('setnx', [$key, $value]);
    }

    public function hmget($key, ...$dictionary)
    {
        if (count($dictionary) === 1) {
            $dictionary = $dictionary[0];
        }
        return array_values($this->command('hmget', [$key, $dictionary]));
    }

    public function hmset($key, ...$dictionary)
    {
        if (count($dictionary) === 1) {
            $dictionary = $dictionary[0];
        } else {
            $input = collect($dictionary);

            $dictionary = $input->nth(2)->combine($input->nth(2, 1))->toArray();
        }

        return $this->command('hmset', [$key, $dictionary]);
    }

    public function hsetnx($hash, $key, $value)
    {
        return (int) $this->command('hsetnx', [$hash, $key, $value]);
    }

    public function lrem($key, $count, $value)
    {
        return $this->command('lrem', [$key, $value, $count]);
    }

    public function blpop(...$arguments)
    {
        $result = $this->command('blpop', $arguments);
        return empty($result) ? null : $result;
    }

    public function brpop(...$arguments)
    {
        $result = $this->command('brpop', $arguments);
        return empty($result) ? null : $result;
    }

    public function spop($key, $count = null)
    {
        return $this->command('spop', [$key]);
    }

    public function zadd($key, ...$dictionary)
    {
        if (is_array(end($dictionary))) {
            foreach (array_pop($dictionary) as $member => $score) {
                $dictionary[] = $score;
                $dictionary[] = $member;
            }
        }
        return $this->executeRaw(array_merge(['zadd', $key], $dictionary));
    }

    public function zrangebyscore($key, $min, $max, $options = [])
    {
        if (isset($options['limit'])) {
            $options['limit'] = [
                $options['limit']['offset'],
                $options['limit']['count'],
            ];
        }

        return $this->command('zRangeByScore', [$key, $min, $max, $options]);
    }

    public function zrevrangebyscore($key, $min, $max, $options = [])
    {
        if (isset($options['limit'])) {
            $options['limit'] = [
                $options['limit']['offset'],
                $options['limit']['count'],
            ];
        }
        return $this->command('zRevRangeByScore', [$key, $min, $max, $options]);
    }

    public function zinterstore($output, $keys, $options = [])
    {
        return $this->command('zInter', [$output, $keys,
            $options['weights'] ?? null,
            $options['aggregate'] ?? 'sum',
        ]);
    }

    public function zunionstore($output, $keys, $options = [])
    {
        return $this->command('zUnion', [$output, $keys,
            $options['weights'] ?? null,
            $options['aggregate'] ?? 'sum',
        ]);
    }

    public function transaction(callable $callback = null)
    {
        $transaction = $this->client->multi();

        return is_null($callback)
            ? $transaction
            : tap($transaction, $callback)->exec();
    }

    public function executeRaw(array $parameters)
    {
        return $this->command('rawCommand', $parameters);
    }

    public function disconnect()
    {
        $this->client->close();
    }


    public function command($method, array $parameters = [])
    {
        $result = $this->client->{$method}(...$parameters);
        return $result;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * Pass other method calls down to the underlying client.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->command($method, $parameters);
    }
}