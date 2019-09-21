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

    public function cachedAction(){
        $cachedData = $this->getRequest()->getParam(CacheUtilityFactory::REQUEST_KEY_CACHED_DATA);
        $cacheExpired = $this->getRequest()->getParam(CacheUtilityFactory::REQUEST_KEY_CACHE_EXPIRED);

        // 检查本方法中得到的 request 中, 是否包含了 __need_cached 字段, 并且值为 true
        if($this->getRequest()->getParam(CacheUtilityFactory::REQUEST_KEY_NEED_CACHED) === true){
            if(!$cachedData){
                // 执行业务逻辑
                $cachedData = $this->cachedActionLogic($this->getRequest());
                // 将业务逻辑放入缓存
                CacheUtilityFactory::getInstance()->set(
                    Yaf_Session::getInstance()->get(CacheUtilityFactory::SESSION_ID_NAME),
                    $this->getRequest()->getRequestUri(),
                    $cachedData,
                    $cacheExpired
                );
            }
        }
        else{
            $cachedData = $this->cachedActionLogic($this->getRequest());
            var_dump(44444);
        }
        echo $cachedData;
    }

    private function cachedActionLogic(Yaf_Request_Abstract $request){
//        $request = RequestFactory::GetLoginRequest($this->getRequest());
//
//        $response = ResponseFactory::GetInstance($request->getType());
//
//        return $response->toJson();
        return 8888;
    }
}
