<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 4/9/19
 * Time: 3:19 PM
 */

namespace AppServices\responses;

class LogoutResponse extends BasicResponse
{
    public function toArray()
    {
        return $this->data;
    }
}