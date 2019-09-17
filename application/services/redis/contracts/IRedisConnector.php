<?php
/**
 * Redis 连接器的接口定义
 */
namespace AppServices\redis\contracts;

interface IRedisConnector
{
    const DRIVER_PHP_REDIS  = 'PhpRedis';
    const DRIVER_PREDIS     = 'Predis';

    const SERVER_DEFAULT    = 'default';
    const SERVER_REMOTE     = 'remote';

    /**
     * Create a new PhpRedis connection.
     * 创建一个新的单点的 PhpRedis 连接
     *
     * @param array $config
     * @param array $options
     * @return IRedisConnection
     */
    public function connect($config, $options);

    /**
     * Create the Redis client instance.
     * 创建 PhpRedis 的 Redis 类实例
     *
     * @param  array  $config
     * @return mixed
     */
    public function createClient(array $config);

    /**
     * Establish a connection with the Redis host.
     * 和 redis 服务器建立连接
     *
     * @param  mixed  $client
     * @param  array  $config
     * @return void
     */
    public function establishConnection($client, array $config);
}