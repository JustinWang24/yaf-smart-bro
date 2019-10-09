<?php
/**
 * 数据库的迁移和升级
 * User: Justin Wang
 */
require_once 'get_db_connection.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use AppServices\database\CapsuleManager;
use Illuminate\Database\Schema\Blueprint;

$capsule = CapsuleManager::GetCapsule();

// 创建用户表: User 表样例
if(!Capsule::schema()->hasTable('users')){
    Capsule::schema()->create('users', function (Blueprint $table){
        $table->bigIncrements('id');
        $table->uuid('uuid')->index()->comment('用户的 UUID');
        $table->string('email',50)->unique()->comment('用户的电子邮件');
        $table->string('password',60)->comment('用户的密码的 salt');
        $table->string('name',60)->comment('用户的名字');
        $table->rememberToken();
        $table->timestamps();
        $table->softDeletes();
    });
    echo '用户表创建成功'.PHP_EOL;
}