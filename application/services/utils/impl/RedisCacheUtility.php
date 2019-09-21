<?php
/**
 * cache 的增删查改
 */

namespace AppServices\utils\impl;
use AppServices\utils\CacheUtilityFactory;
use AppServices\utils\contracts\ICacheUtility;
use AppServices\redis\contracts\IRedisManager;

class RedisCacheUtility implements ICacheUtility
{
    /**
     * @var IRedisManager $redisManager
     */
    private $redisManager;

    /**
     * RedisCacheUtility constructor.
     * @param IRedisManager $manager
     */
    public function __construct(IRedisManager $manager)
    {
        $this->redisManager = $manager;
    }

    /**
     * 构建保存的数据的 key
     *
     * @param $sessionId
     * @param $uri
     * @return string
     */
    private function _buildKey($sessionId, $uri){
        return $sessionId . str_replace('/','_',$uri);
    }

    /**
     * @param $sessionId
     * @param $uri
     * @param boolean $dataStringOnly
     * @return mixed
     */
    public function get($sessionId, $uri, $dataStringOnly = true)
    {
        $realKey = $this->_buildKey($sessionId, $uri);
        $result =  $this->redisManager->connection()
            ->command('HGETALL',[$realKey]);

        if($dataStringOnly){
            return $result['data'] ?? null;
        }else{
            return $result;
        }
    }

    /**
     * 向 redis 中插入 hash 值. 如果值已经存在, 那么就根据 md5 来判断是否需要更新.
     * 如果 md5 不相同, 就更新即可
     *
     * @param $sessionId
     * @param $uri
     * @param $jsonString
     * @param $expiredIn
     * @return int
     */
    public function update($sessionId, $uri, $jsonString, $expiredIn = 0)
    {
        $realKey = $this->_buildKey($sessionId, $uri);   // 构建保存的数据的 key
        $data = CacheUtilityFactory::createDataItemForSave($jsonString);    // 构建需要保存的数据
        $conn = $this->redisManager->connection();
        $result = $this->get($sessionId, $uri, false);

        if($result){
            // 已经存在了, 那么就是更新操作, 包括数据和过期时间
            if($result && isset($result['md']) && $result['md'] !== $data['md']){
                // 需要更新
                $result = $conn->hmset($realKey, $data);
            }
            else{
                // 不需要更新
                $result = 1;
            }
            $this->_setExpire($realKey, $expiredIn);
        }
        else{
            // 不存在, 创建新的
            $result = $conn->hmset($realKey, $data);
        }
        return $result;
    }

    /**
     * @param $sessionId
     * @param $uri
     * @param $jsonString
     * @param int $expiredIn : 秒数, 在多少秒之后过期, 如果是 0, 表示不过期
     * @return int
     */
    public function create($sessionId, $uri, $jsonString, $expiredIn = 0)
    {
        $realKey = $this->_buildKey($sessionId, $uri);   // 构建保存的数据的 key
        $data = CacheUtilityFactory::createDataItemForSave($jsonString);    // 构建需要保存的数据
        $created = $this->redisManager->connection()->hmset($realKey, $data);
        if($created && $expiredIn){
            // 创建成功了, 设置过期的时间
            $this->_setExpire($realKey, $expiredIn);
        }
        return $created;
    }

    public function delete($sessionId, $uri)
    {
        $realKey = $this->_buildKey($sessionId, $uri);   // 构建保存的数据的 key
        $this->redisManager->connection()->command('hdel',[$realKey,'md','data']);
    }

    public function expire($sessionId, $uri, $expiredIn)
    {
        $this->_setExpire($this->_buildKey($sessionId, $uri), $expiredIn);
    }


    private function _setExpire($key, $expiredIn){
        $this->redisManager->connection()->command('expire',[$key, $expiredIn]);
    }
}