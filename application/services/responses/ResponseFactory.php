<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 3/9/19
 * Time: 4:44 PM
 */

namespace AppServices\responses;

use AppServices\requests\RequestFactory;

class ResponseFactory
{
    /**
     * 获取服务器响应对象的工厂方法
     * @param int $requestType
     * @param int $code
     * @param string $message
     * @return BasicResponse
     */
    public static function GetInstance($requestType, $code = null, $message = ''){

        /**
         * @var BasicResponse $instance
         */
        $instance = null;

        switch ($requestType){
            case RequestFactory::V1_TYPE_LOGIN:
                $instance = new LoginResponse($code, $message);
                break;
            case RequestFactory::V1_TYPE_LOGOUT:
                $instance = new LogoutResponse($code, $message);
                break;
            case RequestFactory::V1_TYPE_CLOUD_BAN_CARD:
                $instance = new CloudBanCardResponse($code, $message);
                break;    
            default:
                break;
        }

        return $instance;
    }
}