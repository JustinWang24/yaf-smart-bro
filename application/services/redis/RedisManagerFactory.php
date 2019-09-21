<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 17/9/19
 * Time: 2:14 PM
 */

namespace AppServices\redis;
use AppServices\redis\contracts\IRedisManager;
use AppServices\redis\impl\phpredis\RedisManager;
use AppServices\redis\contracts\IRedisConnector;

class RedisManagerFactory
{
    private static $instance = null;

    /**
     * 获取 Redis Manager 实例
     *
     * @param string $driver
     * @param null $config
     * @return IRedisManager|null
     */
    public static function getInstance($driver = IRedisConnector::DRIVER_PHP_REDIS, $config = null){
        if(empty($config)){
            $location = yaf_config('application.redis.location');
            $config = [
                'host' => yaf_config("application.redis.$location.host"),
                'password' => yaf_config("application.redis.$location.password"),
                'port' => intval(yaf_config("application.redis.$location.port")),
                'database' => intval(yaf_config("application.redis.$location.database")),
            ];
        }
        if($driver === IRedisConnector::DRIVER_PHP_REDIS){
            self::$instance = new RedisManager($driver,$config);
        }
        return self::$instance;
    }
}