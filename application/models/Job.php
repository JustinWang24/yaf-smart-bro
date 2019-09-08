<?php
/**
 * 保存耗时的操作的数据库表
 */

namespace AppModels;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'uuid',
        'type', // 取值自 VerificationUtility 中定义的常量
        'payload_data',
        'complete',
        'result'
    ];

    /**
     * 根据 Uuid 获取Job
     * @param $uuid
     * @return null|Job
     */
    public static function GetByUuid($uuid){
        if(is_string($uuid) && strlen($uuid) > 20){
            return self::where('uuid',$uuid)
                ->first();
        }
        return null;
    }
}