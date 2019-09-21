<?php
/**
 * @name IndexController
 * @author vagrant
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
use AppServices\requests\RequestFactory;
use AppServices\responses\ResponseFactory;
use AppServices\utils\CacheUtilityFactory;

class IndexController extends Yaf_Controller_Abstract {
	/** 
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/auth-server/index/index/index/name/vagrant 的时候, 你就会发现不同
     */
	public function indexAction() {
        echo 'Auth module: v'
            . yaf_config('application.current_version')
            . ', created by Justin Wang. Env: '.YAF_ENVIRON;
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
