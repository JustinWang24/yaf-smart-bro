<?php
/**
 * 获取和保存缓存中数据的工具接口 DAO
 */
namespace AppServices\utils\contracts;

interface ICacheUtility
{
    /**
     * 根据 Session 的 id 和 Uri 的名字, 获取缓存中的 json 数据
     *
     * @param $sessionId
     * @param $uri
     * @param boolean $dataStringOnly : 如果为真, 表示只返回 data 部分的 json 格式的字符串. 否则返回全部
     * @return mixed
     */
    public function get($sessionId, $uri, $dataStringOnly = true);

    /**
     * 以 session id 和 uri 作为 key, 将 $json 数据保存到缓存中.
     * 如果存在, 就更新 redis 中的值. 如果不存在, 就创建它.
     * 这个方法可以替代 create 方法, 但是会多执行 2 个 redis 查询
     *
     * @param $sessionId
     * @param $uri
     * @param $jsonString
     * @param int $expiredIn: 在多少秒之后过期
     * @return int
     */
    public function update($sessionId, $uri, $jsonString, $expiredIn=0);

    /**
     * 以 session id 和 uri 作为 key, 创建一条新的记录
     *
     * @param $sessionId
     * @param $uri
     * @param $jsonString
     * @param int $expiredIn
     * @return int
     */
    public function create($sessionId, $uri, $jsonString, $expiredIn = 0);

    /**
     * 删除 session id 和 uri 指定的值
     *
     * @param $sessionId
     * @param $uri
     * @return void
     */
    public function delete($sessionId, $uri);

    /**
     * 重置 session id 和 uri 指定的过期时间在 $expiredIn 秒之后
     *
     * @param $sessionId
     * @param $uri
     * @param int $expiredIn
     * @return void
     */
    public function expire($sessionId, $uri, $expiredIn);
}