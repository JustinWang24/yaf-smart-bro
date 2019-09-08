<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 4/9/19
 * Time: 3:53 PM
 */

namespace AppServices\queue;

use AppModels\User;
use AppModels\Job;

class MessageFactory
{
    /**
     * @param $type
     * @param User $user
     * @param Job $job
     * @param string $message
     * @return ISystemMessage
     */
    public static function GetMessageInstance($type,$user,$job, $message = ''){
        /**
         * @var ISystemMessage $instance
         */
        $instance = null;

        switch ($type){
            case ISystemMessage::TYPE_SMS:
                $instance = new SmsMessage($job,$user);
                break;
            case ISystemMessage::TYPE_PUSH:
                $instance = new AppPushMessage($job, $user, $message);
                break;
            default:
                break;
        }

        return $instance;
    }
}