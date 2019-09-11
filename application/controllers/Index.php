<?php
/**
 * @name IndexController
 * @author vagrant
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
use AppModels\User;
use AppServices\requests\RequestFactory;
use AppServices\response\ResponseFactory;

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
        return false;
	}

    /**
     * 简单的参考样例
     * @return bool
     */
	public function exampleAction(){
        $request = RequestFactory::GetLoginRequest($this->getRequest());

	    $response = ResponseFactory::GetInstance($request->getType());
	    echo $response->toJson();
	    return false;
    }

}
