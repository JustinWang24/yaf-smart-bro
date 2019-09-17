<?php
/**
 * 所有的异常都会在这个控制器中集中处理
 *
 * @name ErrorController
 * @desc 错误控制器, 在发生未捕获的异常时刻被调用
 * @see http://www.php.net/manual/en/yaf-dispatcher.catchexception.php
 * @author vagrant
 */
class ErrorController extends Yaf_Controller_Abstract {

    /**
     * 从2.1开始, errorAction支持直接通过参数获取异常
     * @param Exception $exception
     * @return boolean
     */
	public function errorAction($exception) {
        var_dump($exception->getMessage());
        switch ($exception->getCode()){
            case 1111:
//                echo $exception->getMessage();
                break;
            default:
                // Log exception locally
                break;
        }
        return false;
	}
}
