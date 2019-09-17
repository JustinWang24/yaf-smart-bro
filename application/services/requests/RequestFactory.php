<?php
/**
 * 请求工厂类
 */

namespace AppServices\requests;

class RequestFactory
{
    // 代表请求类型的值
    const V1_TYPE_LOGIN                 = 1;
    const V1_TYPE_LOGOUT                = 2;
    const V1_TYPE_CLOUD_BAN_CARD        = 3;

    /**
     * 获取 Login 的请求
     * @param \Yaf_Request_Http $request
     * @return LoginRequest
     */
    public static function GetLoginRequest(\Yaf_Request_Http $request){
        return new LoginRequest($request, self::V1_TYPE_LOGIN);
    }

    /**
     * 获取 Logout 的请求
     * @param \Yaf_Request_Http $request
     * @return LogoutRequest
     */
    public static function GetLogoutRequest(\Yaf_Request_Http $request){
        return new LogoutRequest($request, self::V1_TYPE_LOGOUT);
    }


    /**
     * 获取 CloudBanCard 的请求
     * @param \Yaf_Request_Abstract $request
     * @return CloudBanCardRequest
     */
    public static function GetCloudBanCardRequest(\Yaf_Request_Abstract $request)
    {
        return new CloudBanCardRequest($request, self::V1_TYPE_CLOUD_BAN_CARD);
    }
}