<?php
/**
 * 和用户模型相关的一些常量与帮助方法的集合
 */
namespace AppServices\utils;

class UserUtility
{   
    /**
     * 对密码进行加密后返回
     * @param string $passwordInPlainText
     * @param boolean $isMock
     * @return string
     */
    public static function HashPassword($passwordInPlainText, $isMock = false){
        if($isMock){
            return '$2y$10$vZa54Mll/fN457IXjBoVguZ2xdUBUvydRiB7uQW0kiR1Guc.m7Wq.';
        }
        return password_hash($passwordInPlainText,PASSWORD_DEFAULT);
    }

    /**
     * 对进行加密后的密码进行验证
     * @param $passwordInPlainText
     * @param $hash 是 hash password 方法产生的 hash 值
     * @return string
     */
    public static function VerifyPassword($passwordInPlainText, $hash){
        return password_verify($passwordInPlainText,$hash);
    }
}