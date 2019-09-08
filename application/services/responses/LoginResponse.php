<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 3/9/19
 * Time: 4:38 PM
 */
namespace AppServices\response;

class LoginResponse extends BasicResponse
{
    public function toArray()
    {
        return $this->data;
    }
}