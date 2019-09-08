<?php
/**
 * 这个类是为了集成 Eloquent 库并提供一个方便的使用方式而创建的
 */
namespace AppServices\database;

use Illuminate\Database\Capsule\Manager as Capsule;

class CapsuleManager
{
    /**
     * @var Capsule
     */
    private static $capsule;

    /**
     * 初始化 Eloquent
     * @param null $config
     */
    public static function Init($config = null){
        self::$capsule = new Capsule;

        if(is_null($config)){
            $config = [
                'driver'    => yaf_config('application.db.driver'),
                'host'      => yaf_config('application.db.host'),
                'database'  => yaf_config('application.db.database'),
                'username'  => yaf_config('application.db.username'),
                'password'  => yaf_config('application.db.password'),
                'charset'   => yaf_config('application.db.charset'),
                'collation' => yaf_config('application.db.collation'),
                'prefix'    => yaf_config('application.db.prefix'),
            ];
        }

        self::$capsule->addConnection($config);

        // Make this Capsule instance available globally via static methods... (optional)
        self::$capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        self::$capsule->bootEloquent();
    }

    /**
     * 获取 Illuminate\Database\Capsule\Manager 的实例
     * @return Capsule
     */
    public static function GetCapsule(){
        return self::$capsule;
    }
}