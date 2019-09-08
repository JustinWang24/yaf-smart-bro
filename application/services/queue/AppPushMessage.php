<?php
/**
 * 推送 app 消息
 */

namespace AppServices\queue;

use AppModels\Job;
use AppModels\User;

class AppPushMessage implements ISystemMessage
{
    private $user;
    private $job;
    private $message;

    /**
     * SmsMessage constructor.
     * @param Job $job
     * @param User $user
     * @param string $message
     */
    public function __construct(Job $job, User $user, $message = '')
    {
        $this->user = $user;
        $this->job = $job;
        $this->message = $message;
    }


    public function getJobUuid(): string
    {
        return $this->job->uuid;
    }

    public function getType(): string
    {
        return 'PUSH';
    }

    public function getPayload(): ISystemMessagePayload
    {
        return new AppPushMessagePayload($this->job, $this->user, $this->message);
    }

    public function getCallback(): string
    {
        return yaf_config('application.callback.push_complete');
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

    public function push()
    {
        if(!empty($this->message)){
            // Todo: 提交消息到消息队列服务
            $pushed = true;

            // 更新 job 的 payload 数据
            $this->job->payload_data = $this->toJson();
            return ($pushed && $this->job->save()) ? true : false;
        }
        return false;
    }

}