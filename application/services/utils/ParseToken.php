<?php

/**
 * 解析用户token(旧版)
 */

namespace AppServices\utils;

use AppModels\User;
use \Aes as AES;

class ParseToken
{

    // TOKEN相关错误代码
    const ERROR_CODE_TOKEN_ANALYSIS_FAIL = 1301; //token分析失败
    const ERROR_CODE_TOKEN_TIME_EXPIRE   = 1302; //token过期


    private $userId;

    private $timestamp;

    private $salt;

    private $good      = true;

    private $errorCode = 1000;


    public function __construct($token)
    {
        $this->_parse($token);
    }


    private function _parse($token)
    {

        $aes = Aes::create(yaf_config('application.token.aes.key'));

        $decrypToken = $aes->AESDecryptCtr($token);
        $arr         = explode('_', $decrypToken);

        # 干扰字符串
        if (count($arr) != 3 || $arr[2] != yaf_config('application.token.disturb.code')) {
            $this->good      = false;
            $this->errorCode = self::ERROR_CODE_TOKEN_ANALYSIS_FAIL;
        }

        # token过期
        if ($arr[1] < time() - yaf_config('application.token.time')) {
            $this->good      = false;
            $this->errorCode = self::ERROR_CODE_TOKEN_TIME_EXPIRE;
        }

        $this->userId = $arr[0];
    }

    public function isGood()
    {
        return $this->good;
    }

    public function getUserInfo()
    {
        return User::find($this->userId);
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

}