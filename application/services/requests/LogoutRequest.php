<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 4/9/19
 * Time: 2:56 PM
 */

namespace AppServices\requests;


class LogoutRequest extends BasicRequest
{
    public function __construct(\Yaf_Request_Abstract $request, $type)
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