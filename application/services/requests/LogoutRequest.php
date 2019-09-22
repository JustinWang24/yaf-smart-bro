<?php
/**
 * Logout 它和响应类
 */
namespace AppServices\requests;

class LogoutRequest extends BasicRequest
{
    public function __construct(\Yaf_Request_Http $request, $type)
    {
        parent::__construct($request, $type);
    }

    /**
     * 获取用户提交的 uuid
     * @return string
     */
    public function getUserUuid(){
        return $this->get('id');
    }
}