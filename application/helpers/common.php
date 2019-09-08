<?php
/**
 * 在 Yaf 框架被加载之后可以获取配置项的方法
 */
if(!function_exists('yaf_config')){
    function yaf_config($configFullName){
        $v = Yaf_Registry::get('config');
        $arr = explode('.', $configFullName);
        foreach ($arr as $section) {
            $v = $v->get($section);
        }
        return $v;
    }
}


/**
 * 在 Yaf 框架被加载之后可以获取 URI 配置项的快捷方法
 */
if(!function_exists('yaf_config_uri')){
    function yaf_config_uri($name){
        return yaf_config('application.uris.'.$name);
    }
}

/**
 * 生成随机字符串的方法
 */
if(!function_exists('random_string')){
    function random_string($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}