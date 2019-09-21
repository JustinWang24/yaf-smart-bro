<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 17/9/19
 * Time: 7:26 PM
 */

use AppServices\utils\CacheUtilityFactory;

class CheckAnyActionsNeedToBeCachedPlugin extends Yaf_Plugin_Abstract
{
    private $routesShallBeCached = [
        '/api/cached-action' => 60,    // target_uri 需要被缓存, 过期时间是 60 秒
    ];

    /**
     * 在这里检查是否有需要被缓存的路由, 如果有, 那么就进行缓存的处理逻辑
     * @param Yaf_Request_Abstract $request
     * @param Yaf_Response_Abstract $response
     * @return void
     */
    public function dispatchLoopStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        $requestUri = $request->getRequestUri();
        Yaf_Session::getInstance()->start();
        // 我们首先通过 session 的 ID 来获取需要查询的范围
        $sessionId = Yaf_Session::getInstance()->get(
            CacheUtilityFactory::SESSION_ID_NAME
        );

        if(empty($sessionId)){
            Yaf_Session::getInstance()->set(
                CacheUtilityFactory::SESSION_ID_NAME,
                session_create_id(random_string(20))
            );
        }

        // 检查是否当前的 uri 是属于被缓存的
        if($expiredInSeconds = $this->needToCheckCacheFirst($requestUri)){
            // 确认是要被缓存的操作, 所以设置标志位到 request 中
            $request->setParam(CacheUtilityFactory::REQUEST_KEY_NEED_CACHED, true);
            // 将需要缓存的时间传递出去
            $request->setParam(CacheUtilityFactory::REQUEST_KEY_CACHE_EXPIRED, $expiredInSeconds);
            // 如果是需要被缓存的, 那么就去检查缓存是否可以得到有效的数据
            $cachedData = $this->_fetchCachedData($request);
            if($cachedData){
                // 将缓存的结果传递出去, 在 Action 里面就可以取到了
                $request->setParam(CacheUtilityFactory::REQUEST_KEY_CACHED_DATA, $cachedData);
            }
        }
        // 没有获取到缓存的数据, 或者不需要缓存, 那么就正常去执行 controller -> action
    }

    /**
     * 检查是否给定的 uri 属于被缓存的范围, 如果是, 则返回缓存的过期时间, 秒数
     *
     * @param string $uri
     * @return int
     */
    private function needToCheckCacheFirst($uri){
        return $this->routesShallBeCached[$uri] ?? -1;
    }

    /**
     * 从 Redis 缓存中获取当前 session id 下的 当前 uri 的值
     * @param Yaf_Request_Abstract $request
     * @return string|null
     */
    private function _fetchCachedData(Yaf_Request_Abstract $request){
        return CacheUtilityFactory::getInstance()->get(
            Yaf_Session::getInstance()->get(CacheUtilityFactory::SESSION_ID_NAME),
            $request->getRequestUri()
        );
    }
}