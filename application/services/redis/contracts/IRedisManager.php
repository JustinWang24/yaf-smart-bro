<?php
/**
 * Redis 链接管理器的接口定义
 */

namespace AppServices\redis\contracts;

interface IRedisManager
{
    /**
     * Get a Redis connection by name.
     * 根据名字获取 Redis 的连接对象
     *
     * @param  string|null  $name
     * @return IRedisConnection
     */
    public function connection($name = null);

    /**
     * Return all of the created connections.
     *
     * @return IRedisConnection[]
     */
    public function connections();
}