<?php
/**
 * Redis 的客户端管理器
 */

namespace AppServices\redis\impl\phpredis;

use AppServices\redis\contracts\IRedisConnection;
use AppServices\redis\contracts\IRedisConnector;

class RedisManager
{
    /**
     * The name of the default driver.
     * 驱动器的名字
     *
     * @var string
     */
    protected $driver;

    /**
     * The Redis server configurations.
     * Redis 服务器的配置
     *
     * @var array
     */
    protected $config;

    /**
     * The Redis connections.
     * Redis 的连接池
     *
     * @var IRedisConnection[]
     */
    protected $connections;

    /**
     * Create a new Redis manager instance.
     *
     * @param  string  $driver: 驱动名称
     * @param  array  $config: Redis 配置
     * @return void
     */
    public function __construct($driver, array $config)
    {
        $this->driver = $driver;
        $this->config = $config;

        // 产生默认的 connection 并保存到本地连接池中
    }

    /**
     * Get a Redis connection by name.
     * 根据名字获取 Redis 的连接对象
     *
     * @param  string|null  $name
     * @return IRedisConnection
     */
    public function connection($name = null)
    {
        $name = $name ?: IRedisConnector::SERVER_DEFAULT;
        if(!isset($this->connections[$name])){
            // 默认的或者指定的没有找到
            $redis = new \Redis();
            $redis->connect(
                $this->config['host'],$this->config['port']
            );
            $this->connections[$name] = new RedisConnection(
                $redis, $name
            );
        }
        return $this->connections[$name];
    }

    /**
     * Configure the given connection to prepare it for commands.
     *
     * @param  IRedisConnection  $connection
     * @param  string  $name
     * @return IRedisConnection
     */
    protected function configure(IRedisConnection $connection, $name)
    {
        $connection->setName($name);
        return $connection;
    }

    /**
     * Get the connector instance for the current driver.
     *
     * @return IRedisConnector|null
     */
    protected function connector()
    {
        return new RedisConnector();
    }

    /**
     * Return all of the created connections.
     *
     * @return IRedisConnection[]
     */
    public function connections()
    {
        return $this->connections;
    }

    /**
     * Pass methods onto the default Redis connection.
     * 将命令传递给 Redis
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->connection()
            ->{$method}(...$parameters);
    }
}