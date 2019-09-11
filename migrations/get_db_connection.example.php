<?php
/**
 * 在不适用 Yaf 框架的前提下, 创建数据连接
 * 获取数据链接, 请根据自己的实际配置, 进行适当的修改, 然后生成一个本地的 get_db_connection.php 文件即可
 */

require __DIR__.'/../vendor/autoload.php';
use AppServices\database\CapsuleManager;

$config = null;
if(isset($argv[1]) && $argv[1] === 'production'){
    /**
     * 表示是对生产数据的升级迁移操作, 需要在这里使用生产环境的配置
     */
    $config = [];
}

if(isset($argv[1]) && $argv[1] === 'dev'){
    /**
     * 表示是对开发测试数据的升级迁移操作, 需要在这里使用开发环境的配置
     */
    $config = [
        'driver'    => 'mysql',
        'host'      => "127.0.0.1",
        'database'  => "your_database",
        'username'  => "user",
        'password'  => "pwd",
        'charset'   => "utf8mb4",
        'collation' => "utf8mb4_unicode_ci",
        'prefix'    => '',
    ];
}

CapsuleManager::Init($config);