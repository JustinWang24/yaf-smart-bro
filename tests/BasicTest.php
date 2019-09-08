<?php
/**
 * 测试用例的基础类
 */
require_once __DIR__.'/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use AppServices\database\CapsuleManager;
use GuzzleHttp\Client;
use AppServices\requests\RequestFactory;

class BasicTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        // 因为测试用例环节, 并没有启动 yaf 框架, 因此初始化数据库时, 需要将测试数据库的配置传进去
        CapsuleManager::Init([
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => 'purfect_auth',
            'username'  => 'homestead',
            'password'  => 'secret',
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
        ]);
    }

    public function tearDown()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::tearDown();
    }

    /**
     * @param $uri
     * @param $data
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function makePost($uri, $data){
        $client = new Client();
        return $client->request(
            'post',
            'http://auth.xipeng.test'.$uri,
            [
                'form_params'=>$data
            ]
        );
    }

    /**
     * @param $uri
     * @param $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function makeGet($uri, $data){
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://auth.xipeng.test',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);

        return $client->get($uri,[
            'query'=>$data
        ]);
    }

    public function _getMockRequest($uri, $data = []){
        $req = new Yaf_Request_Http($uri, 'http://auth.xipeng.test');
        foreach ($data as $k => $v) {
            $req->setParam($k,$v);
        }
        $req->setParam('user','1000001');
        $req->setParam('type',RequestFactory::V3_TYPE_VERIFICATION_CODE);
        return $req;
    }
}