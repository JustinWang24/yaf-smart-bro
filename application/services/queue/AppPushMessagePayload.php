<?php
/**
 * APP消息推送时的实际数据
 */

namespace AppServices\queue;
use AppModels\Job;
use AppModels\User;

class AppPushMessagePayload implements ISystemMessagePayload
{
    /**
     * @var User $user
     */
    private $user;
    /**
     * @var Job $job
     */
    private $job;

    private $message;

    /**
     * SmsMessagePayload constructor.
     * @param Job $job
     * @param User $user
     * @param string $message
     */
    public function __construct(Job $job, User $user, $message)
    {
        $this->user = $user;
        $this->job = $job;
        $this->message = $message;
    }

    public function getModule(): string
    {
        return 'auth';
    }

    public function getUrl(): string
    {
        return yaf_config('application.services.app.push.center');
    }

    public function getMethod(): string
    {
        return 'post';
    }

    public function getData()
    {
        if(empty($this->message)){
            return [];
        }
        return [
            "device"    => $this->user->profile->device,    // 消息推送用的目标 ID
            "user"      => $this->user->id,     // 关联的用户 ID
            "mobile"    => $this->user->mobile, // 用户手机号码
            "message"   => $this->message       // 需要推送的内容
        ];
    }
}