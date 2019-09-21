<?php
/**
 * 测试 Redis Manager 以及操作 Redis 的方法
 */
require_once __DIR__.'/../BasicTest.php'; // 手工导入

use AppServices\redis\contracts\IRedisConnector;
use AppServices\redis\RedisManagerFactory;
use AppServices\redis\contracts\IRedisManager;

class RedisManagerTest extends BasicTest
{
    private $redisConfig;

    /**
     * @var IRedisManager $redisManager
     */
    private $redisManager;

    private $expectedStringValue = 'unit-test-1-value';

    public function setUp()
    {
        parent::setUp();
        $this->redisConfig = [
            'host' => '127.0.0.1',
            'password' => '',
            'port' => 6379,
            'database' => 0,
        ];

        $this->redisManager = RedisManagerFactory::getInstance(
            IRedisConnector::DRIVER_PHP_REDIS, $this->redisConfig
        );
    }

    public function testItCanInitRedisManager(){
        $this->assertNotNull($this->redisManager);
    }

    public function testItCanInitRedisConnection(){



        $this->assertNotNull($this->redisManager->connection());
    }

    public function testItCanSetValueInToRedis(){
        $done = $this->redisManager->connection()->set('unit-test-1',$this->expectedStringValue);
        $this->assertTrue($done);
    }

    public function testItCanGetValueFromRedis(){
        $value = $this->redisManager->connection()->get('unit-test-1');
        $this->assertEquals($this->expectedStringValue, $value);
    }
}