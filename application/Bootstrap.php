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
		$requestSanitizer = new RequestSanitizerPlugin(); // 安全插件
        $dispatcher->registerPlugin($requestSanitizer);

        // 是否启用缓存
        if(yaf_config('application.cache.redis.enable')){
            $cacheActionInterceptor = new CheckAnyActionsNeedToBeCachedPlugin(); // 缓存插件
            $dispatcher->registerPlugin($cacheActionInterceptor);
        }
	}

	public function _initRoute(Yaf_Dispatcher $dispatcher) {
		//在这里注册自己的路由协议,使用 Rewrite 路由
        $router = $dispatcher->getRouter();


        try{
            // 页面的路由
            $myRoutes = $this->myRoutes();
            foreach ($myRoutes as $myRoute) {
                $router->addRoute(
                    $myRoute['name'],
                    new Yaf_Route_Rewrite(
                        $myRoute['uri'],
                        [
                            'controller'=>$myRoute['c_a']['controller']??'index',
                            'action'    =>$myRoute['c_a']['action']??'index',
                        ]
                    )
                );
            }

            // API 的路由: 登陆接口
            $apiRoutesPrefix = '/api/';
//            $route1 = new Yaf_Route_Rewrite(
//                $apiRoutesPrefix.'user/login',
//                [
//                    'controller'=>'login'
//                ]
//            );
//            $router->addRoute('user_login',$route1);

            // 测试缓存的接口
            $router->addRoute(
                'cached-action',
                new Yaf_Route_Rewrite(
                    $apiRoutesPrefix.'cached-action',
                    [
                        'controller'=>'example',
                        'action'=>'cached',
                    ]
                )
            );

            // AB 测试的一个路由
            if(YAF_ENVIRON === 'dev'){
                $router->addRoute(
                    'user_ab_test',
                    new Yaf_Route_Rewrite(
                        $apiRoutesPrefix.'user/ab-test',
                        [
                            'controller'=>'example',
                            'action'=>'test'
                        ]
                    )
                );
            }
        } catch (Exception $exception){
            // Todo: Log 到日志服务器
        }
	}
	
	public function _initView(Yaf_Dispatcher $dispatcher) {
	    if(strpos($dispatcher->getRequest()->getRequestUri(),'/api/') === 0){
	        // 这是API路由, 不需要加载 view, 默认都是返回 json 格式字符串
            $dispatcher->disableView();
        } else {
	        // 非API
            if(!yaf_config('application.view.enable')){
                $dispatcher->disableView();
            }
            //在这里注册自己的view控制器，例如smarty,firekylin
        }
	}

    /**
     * 定义自己的路由. 注意，不需要定义默认首页的的路由, 采用Yaf自定义的Index控制器的index方法即可
     * @return array[]
     */
	private function myRoutes(){
	    return [
            [
                'uri'=>'/about',  // 路由的方法
                'c_a'=>[
                    'controller'=>'index',
                    'action'=>'about',
                ],   // 映射到那个控制器与方法
                'name'=>'page-about',  // 路由的名字
            ]
        ];
    }

    private function myApiRoutes(){
        return [
            [
                'uri'=>'/',  // 路由的方法
                'c_a'=>[],   // 映射到那个控制器与方法
                'name'=>'',  // 路由的名字
            ]
        ];
    }
}
