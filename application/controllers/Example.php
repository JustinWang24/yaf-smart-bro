<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 22/9/19
 * Time: 12:53 PM
 */
use AppServices\requests\RequestFactory;
use AppServices\responses\ResponseFactory;
use AppServices\utils\CacheUtilityFactory;
use AppModels\User;

class ExampleController extends Yaf_Controller_Abstract{
    /**
     * For AB test
     */
    public function testAction(){

        foreach (range(1, 100) as $item) {
            User::find($item);
        }
        echo 'ab test action';
    }

    /**
     * 简单的参考样例
     */
    public function exampleAction(){
        $request = RequestFactory::GetLoginRequest($this->getRequest());

        $response = ResponseFactory::GetInstance($request->getType());
        echo $response->toJson();
    }

    /**
     * 模拟一个需要缓存的 API 接口的 Action
     */
    public function cachedAction(){
        $cachedData = $this->getRequest()->getParam(CacheUtilityFactory::REQUEST_KEY_CACHED_DATA);
        $cacheExpired = $this->getRequest()->getParam(CacheUtilityFactory::REQUEST_KEY_CACHE_EXPIRED);

        // 检查本方法中得到的 request 中, 是否包含了 __need_cached 字段, 并且值为 true
        if($this->getRequest()->getParam(CacheUtilityFactory::REQUEST_KEY_NEED_CACHED) === true){
            if(!$cachedData){ // 发现没有从缓存里取得数据
                // 执行业务逻辑
                $cachedData = $this->cachedActionLogic($this->getRequest());
                // 将业务逻辑放入缓存
                CacheUtilityFactory::getInstance()->create(
                    Yaf_Session::getInstance()->get(CacheUtilityFactory::SESSION_ID_NAME),
                    $this->getRequest()->getRequestUri(),
                    $cachedData,
                    $cacheExpired
                );
            }else{
                // 从缓存里面取得了数据, 那么就更新一下过期时间即可
                CacheUtilityFactory::getInstance()->expire(
                    Yaf_Session::getInstance()->get(CacheUtilityFactory::SESSION_ID_NAME),
                    $this->getRequest()->getRequestUri(),
                    $cacheExpired
                );
            }
        }
        else{
            // 不需要缓存
            $cachedData = $this->cachedActionLogic($this->getRequest());
        }
        echo $cachedData;
    }

    /**
     * 执行业务逻辑的方法样例, 获取数据
     *
     * @param Yaf_Request_Abstract $request
     * @return int
     */
    private function cachedActionLogic(Yaf_Request_Abstract $request){

        return 8888;
    }
}