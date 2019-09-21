<?php
/**
 * 缓存操作工具类
 */

namespace AppServices\utils;
use AppServices\redis\RedisManagerFactory;
use AppServices\redis\contracts\IRedisManager;
use AppServices\utils\contracts\ICacheUtility;
use AppServices\utils\impl\RedisCacheUtility;

class CacheUtilityFactory
{
    const SESSION_ID_NAME           = '_session_id';        // 在 session 中用来保存 session id 的参数名
    const REQUEST_KEY_NEED_CACHED   = '__need_cached';      // 在 request 中参数名, 用来保存本次操作是否需要缓存
    const REQUEST_KEY_CACHE_EXPIRED = '__cache_expired';    // 在 request 中参数名, 用来保存本次缓存的过期时间
    const REQUEST_KEY_CACHED_DATA   = '__cached_data';      // 在 request 中参数名, 用来保存的取到的缓存中的数据

    /**
     * @var ICacheUtility $cacheUtility
     */
    private static $cacheUtility;

    /**
     * 获取操作 Cache 的工具类实例
     *
     * @param IRedisManager $manager
     * @return ICacheUtility|RedisCacheUtility
     */
    public static function getInstance(IRedisManager $manager = null){
        if(!self::$cacheUtility){
            self::$cacheUtility = new RedisCacheUtility(
                $manager ?? RedisManagerFactory::getInstance()
            );
        }
        return self::$cacheUtility;
    }

    /**
     * 本方法用来在保存到缓存之前, 对数据进行一个简单的打包操作. 根据传入的
     * 实际需要保存的数据, 计算它的 md5 的值, 该值用来以后的校验比较. 比如是否需要更新数据
     *
     * @param string|array $dataInJsonString
     * @return array
     */
    public static function createDataItemForSave($dataInJsonString){
        if(is_array($dataInJsonString)){
            $dataInJsonString = json_encode($dataInJsonString);
        }
        return [
            'md'=>md5($dataInJsonString),
            'data'=>$dataInJsonString
        ];
    }
}