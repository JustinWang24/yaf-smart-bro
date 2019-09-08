<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 6/9/19
 * Time: 4:13 PM
 */

namespace AppServices\requests;


interface HasPassword
{
    /**
     * 获取密码的方法
     * @return string
     */
    public function getPassword();
}