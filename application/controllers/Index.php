<?php
/**
 * @name IndexController
 * @author vagrant
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
use AppServices\requests\RequestFactory;
use AppServices\utils\UserUtility;
use AppServices\responses\ResponseFactory;

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


    
    public function tokenAction()
    {

        $userInfo = UserUtility::checkToken('1tF9XUBAQEAyk6m/1ZiiItNqtgI5KpuiKuigTOkg0VJoidzMwL7nGJIM9t1y');

        dump($userInfo);die;
        // $aes = Aes::create(yaf_config('application.token.aes.key'));  
        // $aa  = $aes->AESEncryptCtr( '1233234234' );
        // dump($aa);die;
        return false;
    }

}
