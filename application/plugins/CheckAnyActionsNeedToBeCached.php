<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 17/9/19
 * Time: 7:26 PM
 */

class CheckAnyActionsNeedToBeCached extends Yaf_Plugin_Abstract
{
    /**
     * 在这里检查是否有需要被缓存的路由, 如果有, 那么就进行缓存的处理逻辑
     * @param Yaf_Request_Abstract $request
     * @param Yaf_Response_Abstract $response
     * @return void
     */
    public function dispatchLoopStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        $routesShallBeCached = [];



    }
}