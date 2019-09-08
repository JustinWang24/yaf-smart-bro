<?php
/**
 * 这个工厂文件是为了方便的生成测试用的 mock 数据而编写的, 不可用于开发环境以外的场景
 */

require_once __DIR__.'/../vendor/autoload.php';

/**
 * 通用的工厂方法, 可以返回指定的 class name 的对象
 * @param $className
 * @param $callable
 * @return mixed
 */
function factory($className, $callable){
    $faker = Faker\Factory::create();
    $data = $callable($faker);
    return new $className($data);
}