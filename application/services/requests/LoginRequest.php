<?php
/**
 * 用户登录的请求
 */
namespace AppServices\requests;

class LoginRequest extends BasicRequest implements HasPassword
{
    public function __construct(\Yaf_Request_Http $request, $type)
    {
        parent::__construct($request, $type);
    }

    public function getName(){
        return $this->get('name');
    }

    public function getType(){
        return $this->get('type');
    }

    public function getPassword(){
        return $this->get('password');
    }

    public function getDevice(){
        return $this->get('device');
    }

    public function needToBeRemembered(){
        return $this->get('remember');
    }
}