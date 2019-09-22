<?php
/**
 * 这是一个测试用例的样本文件.
 * 注意任何测试用例, 如果要继承 BasicTest, 需要在测试类头部加入 require 语句导入它.
 * 无论是单元测试还是功能测试都一样
 */

require_once __DIR__.'/../BasicTest.php'; // 手工导入

class UserDaoTest extends BasicTest
{
    public function testItCanGetTrue(){
        try{
            // 确保 uuid 是可以被调用的
            $uuid = uuid();
            $this->assertNotNull($uuid);
        }catch (Exception $exception){
            var_dump($exception->getMessage());
        }
    }
}