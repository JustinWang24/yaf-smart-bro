<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 4/9/19
 * Time: 6:49 PM
 */

namespace AppServices\queue;

use AppModels\Job;
use AppModels\User;

class SmsMessagePayload implements ISystemMessagePayload
{
    /**
     * @var User $user
     */
    private $user;
    /**
     * @var Job $job
     */
    private $job;

    /**
     * SmsMessagePayload constructor.
     * @param Job $job
     * @param User|null $user
     */
    public function __construct(Job $job, User $user = null)
    {
        $this->user = $user;
        $this->job = $job;
    }

    public function getModule(): string
    {
        return 'auth';
    }

    public function getUrl(): string
    {
        return yaf_config('application.services.sms.center');
    }

    public function getMethod(): string
    {
        return 'post';
    }

    public function getData()
    {
        $code = random_int(100000,999999);
        return [
            "device"    => "",                  // 消息推送用的目标 ID
            "user"      => $this->user->id ? $this->user->id : 0,     // 关联的用户 ID, 可能是新用户
            "mobile"    => $this->user->mobile, // 收信号码
            "message"   => $this->_wrapSmsText($code)  // 短信的内容
        ];
    }

    /**
     * @param $content
     * @return string
     */
    private function _wrapSmsText($content){
        return '【'.
            yaf_config('application.owner.name.sms').
            '】您的验证码'.$content.'，请在1分钟内按页面提示提交验证码，切勿将验证码泄露于他人。';
    }
}