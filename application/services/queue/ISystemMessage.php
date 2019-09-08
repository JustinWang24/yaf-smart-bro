<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 4/9/19
 * Time: 3:44 PM
 */
namespace AppServices\queue;

interface ISystemMessage
{
    const TYPE_SMS  = 1;
    const TYPE_PUSH = 2;

    /**
     * 返回 job 的 unique id 字符串
     * @return string
     */
    public function getJobUuid(): string ;

    /**
     * 返回消息类型的字符串
     * @return string
     */
    public function getType(): string ;

    /**
     * 获取消息内容
     * @return ISystemMessagePayload
     */
    public function getPayload(): ISystemMessagePayload;

    /**
     * 获取任务回调的 URL
     * @return string
     */
    public function getCallback(): string ;

    /**
     * 将消息转换成 json 字符串
     * @return string
     */
    public function toJson(): string;

    /**
     * 把自己推到某个远端的服务
     * @return boolean
     */
    public function push();
}