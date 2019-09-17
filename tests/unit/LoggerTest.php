<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 17/9/19
 * Time: 9:12 PM
 */

require_once __DIR__.'/../BasicTest.php';
class LoggerTest extends BasicTest
{

    public function testItCanLogSomething(){
        SeasLog::setLogger('unit-test-module');
        SeasLog::log(SEASLOG_INFO, 'UNIT TEST: '.date('Y-m-d H:i:s'));
        $this->assertTrue(1===1);
    }
}