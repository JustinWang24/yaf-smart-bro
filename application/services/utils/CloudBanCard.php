<?php

namespace AppServices\utils;

use AppModels\School;
use AppModels\SchoolCloud;
use AppModels\SchoolArea;


/**
 * 云班牌
 */
class CloudBanCard
{	


	// 错误代码
    const ERROR_CODE_REDO                        = 999;  // 专用于回调的重发
    const ERROR_CODE_OK                          = 1000; // 一切正常
    const ERROR_CODE_API_ERROR                   = 1999; // API服务器错误
    const ERROR_CODE_DATABASE_ERROR              = 1998; // API数据库错误

    // 云班牌相关的错误代码
    const ERROR_CODE_CLOUD_CODE_NOT_MATCH        = 1401; // 设备码错误
    const ERROR_CODE_SCHOOL_NOT_EXIST            = 1402; // 学校不存在

    /**
     * 根据错误消息代码获取错误消息文本
     * @param $errorCode
     * @return string
     */
    public static function GetErrorMessage($errorCode){
        $errors = [
            self::ERROR_CODE_OK                   => '',
            self::ERROR_CODE_CLOUD_CODE_NOT_MATCH => '设备码错误',
            self::ERROR_CODE_SCHOOL_NOT_EXIST     => '学校不存在',
            self::ERROR_CODE_API_ERROR            => 'API服务器错误',
            self::ERROR_CODE_DATABASE_ERROR       => 'API数据库错误',
        ];
        return $errors[$errorCode] ?? '系统错误';
    }

	/**
     * 根据提交的云班牌设备号, 来获取学校
     * @param $code
     * @return bool
     */
    public static function GetSchoolByCode($code)
    {
        $result = SchoolCloud::where('cloud_code', $code)->first();
        if (!$result) {
        	return self::ERROR_CODE_CLOUD_CODE_NOT_MATCH;
        }
        return $result;
    }

    /**
     * 获取分校详细信息
     * @param $school
     * @return bool
     */
    public static function GetSchoolAreaInfo($school)
    {
        $result = SchoolArea::where('schoolareaid', $school->schoolarea_id)->first();
        if (!$result) {
            return self::ERROR_CODE_SCHOOL_NOT_EXIST;
        }
        return $result;
    }

    /**
     * 获取学校详细信息
     * @param $school
     * @return bool
     */
    public static function GetSchoolInfo($school)
    {
        $result = School::where('schoolid', $school->school_id)->first();
        if (!$result) {
            return self::ERROR_CODE_SCHOOL_NOT_EXIST;
        }
        return $result;
    }
}