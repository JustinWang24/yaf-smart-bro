<?php
/**
 * 创建测试数据的脚本
 * 命令行:
 */
require_once 'get_db_connection.php';
require_once 'database_factory.php';

use Faker\Generator as Faker;
use AppModels\User;
use AppServices\database\CapsuleManager;

// 以下为利用 faker 生成数据的样例

CapsuleManager::GetCapsule()->getDatabaseManager()->beginTransaction();

$user = factory(
    User::class,
    function(Faker $faker) {
        return [
            'name'=>$faker->name,
        ];
    }
);
$user->save();

CapsuleManager::GetCapsule()->getDatabaseManager()->commit();
echo '测试数据创建完毕'.PHP_EOL;