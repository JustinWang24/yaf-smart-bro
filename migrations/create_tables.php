<?php
/**
 * 数据库的迁移和升级
 * User: Justin Wang
 */
require __DIR__.'/../vendor/autoload.php';
require_once 'get_db_connection.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use AppServices\database\CapsuleManager;
use Illuminate\Database\Schema\Blueprint;

$capsule = CapsuleManager::GetCapsule();

// 创建用户表: User 表样例
if(!Capsule::schema()->hasTable('users')){
    Capsule::schema()->create('users', function (Blueprint $table){
        $table->bigIncrements('id');
        $table->uuid('uuid')->index();
        $table->string('email',50)->unique();
        $table->string('password',60);
        $table->string('name',60);
        $table->rememberToken();
        $table->timestamps();
        $table->softDeletes();
    });
    echo '用户表创建成功'.PHP_EOL;
}