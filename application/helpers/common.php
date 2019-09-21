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

if(!function_exists('dump'))
{
    /**
     * 浏览器友好的变量输出
     * @param mixed $var 变量
     * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
     * @param string $label 开头标签 默认为空
     * @param boolean $strict 是否严谨 默认为true
     * @return mixed
     */
    function dump($var, $echo=true, $label=null, $strict=true)
    {
        $label = ($label === null) ? '' : rtrim($label) . ' ';
        if (!$strict) {
            if (ini_get('html_errors')) {
                $output = print_r($var, true);
                $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            } else {
                $output = $label . print_r($var, true);
            }
        } else {
            ob_start();
            var_dump($var);
            $output = ob_get_clean();
            if (!extension_loaded('xdebug')) {
                $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
                $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            }
        }
        if ($echo) {
            echo($output);
            return null;
        }else
            return $output;
    }
}