<?php
/**
 * 测试用例的基础类
 */
require_once __DIR__.'/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use AppServices\database\CapsuleManager;
use GuzzleHttp\Client;

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

    /**
     * @param $uri
     * @param array $data
     * @param $type
     * @return Yaf_Request_Http
     */
    public function _getMockRequest($uri, $data = [], $type){
        $req = new Yaf_Request_Http($uri, 'http://auth.xipeng.test');
        foreach ($data as $k => $v) {
            $req->setParam($k,$v);
        }
        $req->setParam('type',$type);
        return $req;
    }

    /**
     * @param $params
     * @param $action
     * @param $controller
     * @param string $module
     * @return Yaf_Request_Simple
     */
    public function _getMockSimpleRequest($params, $action, $controller, $module = 'Index'){
        try{
            return new Yaf_Request_Simple(
                "CLI", $module, $controller, $action, $params);
        }catch (Exception $exception){
        }
    }

    /**
     * 判断两个值是绝对相等的
     * @param $expect
     * @param $actual
     * @param string $msg
     */
    protected function assertAbsoluteEquals($expect, $actual, $msg = '两个值不是绝对的相等'){
        $this->assertTrue($expect === $actual, $msg);
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return array
     */
    protected function _getJson($response){
        return json_decode($response->getBody()->getContents(), true);
    }
}