<?php
/**
 * 请求参数的过滤保护中间件
 * 鉴于实际的应用场景, 目前提交的数据都是单层的, 无论是 post 还是 get 方法提交的
 */

class RequestSanitizerPlugin extends Yaf_Plugin_Abstract
{
    /**
     * 在 request 数据转发到控制器之前, 进行数据的过滤工作. 防止注入攻击
     * @param Yaf_Request_Abstract $request
     * @param Yaf_Response_Abstract $response
     * @return void
     */
    public function preDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        $params = $request->getParams();
        foreach ($params as $key => $v) {
            // Todo: 后续完成对 request 中的数据进行过滤的各项功能
            $v = trim($v);  // 去除字符串的左右侧的空格
            $request->setParam($key, $v);
        }
    }

    /**
     * @param $str
     */
    private function escape($str){

    }

    public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    public function dispatchLoopStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    public function postDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }
}