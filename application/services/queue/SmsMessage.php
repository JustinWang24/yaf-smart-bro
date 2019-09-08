<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 4/9/19
 * Time: 6:03 PM
 */

namespace AppServices\queue;
use AppModels\Job;
use AppModels\User;

class SmsMessage implements ISystemMessage
{
    /**
     * @var Job $job
     */
    private $job;
    /**
     * @var User
     */
    private $user;

    /**
     * SmsMessage constructor.
     * @param Job $job
     * @param User|null $user
     */
    public function __construct(Job $job, User $user = null)
    {
        $this->user = $user;
        $this->job = $job;
    }

    public function getJobUuid(): string
    {
        return $this->job->uuid;
    }

    public function getType(): string
    {
        return 'SMS';
    }

    public function getPayload(): ISystemMessagePayload
    {
        return new SmsMessagePayload($this->job,$this->user);
    }

    public function getCallback(): string
    {
        return yaf_config('application.callback.verification_code');
    }

    public function toJson(): string
    {
        $data = [
            'job'       =>$this->getJobUuid(),
            'type'      =>$this->getType(),
            'cb'        =>$this->getCallback(),
            'payload'   =>$this->getPayload()->getData()
        ];
        return json_encode($data);
    }

    /**
     * 提交消息到消息队列服务
     * @return bool
     */
    public function push()
    {
        // Todo: 提交消息到消息队列服务
        $pushed = true;

        // 更新 job 的 payload 数据
        $this->job->payload_data = $this->toJson();
        return ($pushed && $this->job->save()) ? true : false;
    }
}