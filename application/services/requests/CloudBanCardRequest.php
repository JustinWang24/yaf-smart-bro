<?php

namespace AppServices\requests;

/**
 * 云班牌的请求
 */
class CloudBanCardRequest extends BasicRequest
{
    public function __construct(\Yaf_Request_Abstract $request, $type)
    {
        parent::__construct($request, $type);
    }

    public function getCode()
    {
        return $this->get('code');
    }

}