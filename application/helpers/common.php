<?php
/**
 * 可到处直接使用的帮助方法
 */
if(!function_exists('yaf_config')){
    /**
     * 在 Yaf 框架被加载之后可以获取配置项的方法
     *
     * @param $configFullName: 配置项的全名
     * @return mixed
     */
    function yaf_config($configFullName){
        $v = Yaf_Registry::get('config');
        $arr = explode('.', $configFullName);
        foreach ($arr as $section) {
            $v = $v->get($section);
        }
        return empty($v) ? null : $v;
    }
}

if(!function_exists('yaf_config_uri')){
    /**
     * 在 Yaf 框架被加载之后可以获取 URI 配置项的快捷方法
     *
     * @param $name
     * @return mixed
     */
    function yaf_config_uri($name){
        return yaf_config('application.uris.'.$name);
    }
}

if(!function_exists('random_string')){
    /**
     * 生成随机字符串的方法
     *
     * @param int $length
     * @return string
     */
    function random_string($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if(!function_exists('uuid')){
    /**
     * 利用扩展生成 uuid 的帮助方法
     *
     * @return string
     */
    function uuid(){
        return uuid_create(UUID_TYPE_RANDOM);
    }
}