<?php
/**
 * Redis 连接接口
 */
namespace AppServices\redis\contracts;

interface IRedisConnection
{
    /**
     * Run a command against the Redis database.
     * 运行一个 redis 命令
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function command($method, array $parameters = []);

    /**
     * 获取指定的 key 所关联的数据
     *
     * @param string $key
     * @return mixed
     */
    public function get($key);

    /**
     * 获取指定的 keys 所关联的所有数据
     *s
     * @param array $keys
     * @return mixed
     */
    public function mget(array $keys);

    /**
     * 是否给定的 keys 的值是存在的
     * Determine if the given keys exist.
     *
     * @param mixed $keys
     * @return int
     */
    public function exists(...$keys);

    /**
     * Set the string value in argument as value of the key.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param  string|null  $expireResolution
     * @param  int|null  $expireTTL
     * @param  string|null  $flag
     * @return bool
     */
    public function set($key, $value, $expireResolution = null, $expireTTL = null, $flag = null);

    /**
     * Set the given key if it doesn't exist.
     *
     * @param  string  $key
     * @param  string  $value
     * @return int
     */
    public function setnx($key, $value);

    /**
     * Get the value of the given hash fields.
     *
     * @param  string  $key
     * @param  mixed $dictionary
     * @return int
     */
    public function hmget($key, ...$dictionary);

    /**
     * Set the given hash fields to their respective values.
     *
     * @param  string  $key
     * @param  mixed  $dictionary
     * @return int
     */
    public function hmset($key, ...$dictionary);

    /**
     * Set the given hash field if it doesn't exist
     * 设置给定的哈希字段, 如果不存在
     *
     * @param  string  $hash
     * @param  string  $key
     * @param  string  $value
     * @return int
     */
    public function hsetnx($hash, $key, $value);

    /**
     * Removes the first count occurrences of the value element from the list.
     * 从列表中移除Value元素出现的第一次计数
     *
     * @param  string  $key
     * @param  int  $count
     * @param  $value  $value
     * @return int|false
     */
    public function lrem($key, $count, $value);

    /**
     * Removes and returns the first element of the list stored at key.
     * 删除并返回在 key 中保存的的第一个元素
     *
     * @param  mixed $arguments
     * @return array|null
     */
    public function blpop(...$arguments);

    /**
     * Removes and returns the last element of the list stored at key.
     * 删除并返回在 key 中保存的的最后一个元素
     *
     * @param  mixed  $arguments
     * @return array|null
     */
    public function brpop(...$arguments);

    /**
     * Removes and returns a random element from the set value at key.
     * 删除并返回在 key 中保存的随机一个元素
     *
     * @param  string  $key
     * @param  int|null  $count
     * @return mixed|false
     */
    public function spop($key, $count = null);

    /**
     * Add one or more members to a sorted set or update its score if it already exists.
     *
     * @param  string  $key
     * @param  mixed $dictionary
     * @return int
     */
    public function zadd($key, ...$dictionary);

    /**
     * Return elements with score between $min and $max.
     *
     * @param  string  $key
     * @param  mixed  $min
     * @param  mixed  $max
     * @param  array  $options
     * @return int
     */
    public function zrangebyscore($key, $min, $max, $options = []);

    /**
     * Return elements with score between $min and $max.
     *
     * @param  string  $key
     * @param  mixed  $min
     * @param  mixed  $max
     * @param  array  $options
     * @return int
     */
    public function zrevrangebyscore($key, $min, $max, $options = []);

    /**
     * Find the intersection between sets and store in a new set.
     *
     * @param  string  $output
     * @param  array  $keys
     * @param  array  $options
     * @return int
     */
    public function zinterstore($output, $keys, $options = []);

    /**
     * Find the union between sets and store in a new set.
     *
     * @param  string  $output
     * @param  array  $keys
     * @param  array  $options
     * @return int
     */
    public function zunionstore($output, $keys, $options = []);

    /**
     * Execute commands in a transaction.
     *
     * @param  callable  $callback
     * @return \Redis|array
     */
    public function transaction(callable $callback = null);

    /**
     * Execute a raw command.
     *
     * @param  array  $parameters
     * @return mixed
     */
    public function executeRaw(array $parameters);

    /**
     * Disconnects from the Redis instance.
     *
     * @return void
     */
    public function disconnect();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param $name
     * @return void
     */
    public function setName($name);
}