<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 21/9/19
 * Time: 8:16 PM
 */
require_once __DIR__.'/../BasicTest.php'; // 手工导入

use AppServices\utils\CacheUtilityFactory;
use AppServices\utils\contracts\ICacheUtility;
use AppServices\redis\RedisManagerFactory;
use AppServices\redis\contracts\IRedisConnector;

class RedisCacheUtilityTest extends BasicTest
{
    /**
     * @var ICacheUtility $cacheUtil
     */
    private $cacheUtil;

    public function setUp()
    {
        parent::setUp();
        $redisConfig = [
            'host' => '127.0.0.1',
            'password' => '',
            'port' => 6379,
            'database' => 0,
        ];

        $redisManager = RedisManagerFactory::getInstance(
            IRedisConnector::DRIVER_PHP_REDIS, $redisConfig
        );

        $this->cacheUtil = CacheUtilityFactory::getInstance($redisManager);
    }

    public function testCanInteractWithRedis(){
        $sessionId = 'the-session-id-'.time();
        $uri = '/api/test-api';
        $data = [
            'name'=>'someone',
            'age'=>47,
            'school'=>[
                'name'=>'test',
                'type'=>'uni'
            ]
        ];
        // 测试可以创建一个新的
        $result =  $this->cacheUtil->create(
            $sessionId,
            $uri,
            $data,
            60
        );
        $this->assertEquals(1, $result);

        // 测试可以获取刚刚创建的
        $exist = $this->cacheUtil->get($sessionId, $uri);
        $this->assertNotNull($exist);
        $retrievedData = json_decode($exist, true);

        $this->assertArrayHasKey('name', $retrievedData);
        $this->assertArrayHasKey('age', $retrievedData);
        $this->assertEquals(47, $retrievedData['age']);
        $this->assertArrayHasKey('name', $retrievedData['school']);
        $this->assertArrayHasKey('type', $retrievedData['school']);

        // 测试可以更新数据
        $data = [
            'name'=>'someone',
            'age'=>57,
            'school'=>[
                'name'=>'test',
                'type'=>'uni'
            ]
        ];
        $result =  $this->cacheUtil->update(
            $sessionId,
            $uri,
            $data,
            60
        );
        $this->assertEquals(1, $result);

        // 测试数据确实被更新了
        $updated = $this->cacheUtil->get($sessionId, $uri);
        $updatedData = json_decode($updated, true);
        $this->assertEquals(57, $updatedData['age']);

        // 测试可以删除数据
        $this->cacheUtil->delete($sessionId, $uri);
        $existed = $this->cacheUtil->get($sessionId, $uri);
        $this->assertNull($existed);
    }

    /**
     * 在保存 json 字符串到 redis 之前, 确保是可以将数据打包的
     */
    public function testCanCreateDataBeforeSaveIntoRedis(){
        $data = CacheUtilityFactory::createDataItemForSave([
            'name'=>'someone',
            'age'=>44
        ]);

        $data2 = CacheUtilityFactory::createDataItemForSave([
            'name'=>'someone',
            'age'=>44
        ]);

        $this->assertArrayHasKey('md', $data);
        $this->assertArrayHasKey('md', $data2);
        $this->assertEquals($data['md'], $data2['md']);
    }

    /**
     * 测试能初始化缓存工具类
     */
    public function testCanInitCacheUtil(){
        $this->assertNotNull($this->cacheUtil);
    }
}