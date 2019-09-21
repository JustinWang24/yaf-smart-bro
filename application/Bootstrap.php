<?php
/**
 * @name Bootstrap
 * @author vagrant
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
use AppServices\database\CapsuleManager;

class Bootstrap extends Yaf_Bootstrap_Abstract {

    public function _initConfig() {
		//把配置保存起来
		$arrConfig = Yaf_Application::app()->getConfig();
		Yaf_Registry::set('config', $arrConfig);
	}

    /**
     * 自定义的 init 方法, 专门用来初始化数据库链接. 它会在 _initConfig 之后被调用
     */
	public function _initDatabaseConnection(){
        CapsuleManager::Init();
    }

	public function _initPlugin(Yaf_Dispatcher $dispatcher) {
		//注册一个插件
//		$objSamplePlugin = new SamplePlugin();
		$requestSanitizer = new RequestSanitizerPlugin();
		$cacheActionInterceptor = new CheckAnyActionsNeedToBeCachedPlugin();

		$dispatcher->registerPlugin($requestSanitizer);
		$dispatcher->registerPlugin($cacheActionInterceptor);
	}

	public function _initRoute(Yaf_Dispatcher $dispatcher) {
		//在这里注册自己的路由协议,使用 Rewrite 路由
        $router = $dispatcher->getRouter();
        $apiRoutesPrefix = '/api/';
        try{
            // 登陆接口
            $route1 = new Yaf_Route_Rewrite(
                $apiRoutesPrefix.'user/login',
                [
                    'controller'=>'login'
                ]
            );
            $router->addRoute('user_login',$route1);

            // 登出接口
            $route2 = new Yaf_Route_Rewrite(
                $apiRoutesPrefix.'user/logout',
                [
                    'controller'=>'logout'
                ]
            );
            $router->addRoute('user_logout',$route2);

            // 测试缓存的接口
            $route3 = new Yaf_Route_Rewrite(
                $apiRoutesPrefix.'cached-action',
                [
                    'controller'=>'index',
                    'action'=>'cached',
                ]
            );
            $router->addRoute('cached-action',$route3);

            // AB 测试的一个路由
            if(YAF_ENVIRON === 'dev'){
                $route7 = new Yaf_Route_Rewrite(
                    $apiRoutesPrefix.'user/ab-test',
                    [
                        'controller'=>'index',
                        'action'=>'test'
                    ]
                );
                $router->addRoute('user_findUserPasswordInfo',$route7);
            }
        } catch (Exception $exception){
            // Todo: Log 到日志服务器
        }
	}
	
	public function _initView(Yaf_Dispatcher $dispatcher) {
		//在这里注册自己的view控制器，例如smarty,firekylin
        $dispatcher->disableView();
	}
}
