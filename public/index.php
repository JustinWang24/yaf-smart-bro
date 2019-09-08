<?php
define('APPLICATION_PATH', dirname(dirname(__FILE__)));
define('GLOBAL_URI_PREFIX', '/api/'); // 路由的统一前缀
require APPLICATION_PATH . '/vendor/autoload.php';
$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");

$application->bootstrap()->run();
?>
