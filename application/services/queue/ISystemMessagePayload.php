<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 4/9/19
 * Time: 3:47 PM
 */

namespace AppServices\queue;

interface ISystemMessagePayload
{
    /**
     * 获取代表自己的模块名
     * @return string
     */
    public function getModule(): string ;

    /**
     * 获取对应的服务模块 url
     * @return string
     */
    public function getUrl(): string ;

    /**
     * 获取对应的 HTTP 方法名
     * @return string
     */
    public function getMethod(): string ;

    /**
     * 获取具体的数据
     * @return array
     */
    public function getData();
}