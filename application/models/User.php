<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 31/8/19
 * Time: 12:25 AM
 */
namespace AppModels;

use AppServices\utils\UserUtility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'uuid','mobile','password','status','mobile_verified_at','type','email','name'
    ];

    /**
     * 根据 Uuid 获取用户的数据, 如果提供了 $rememberToken 则必须相等
     * @param $uuid
     * @param $rememberToken
     * @return null|User
     */
    public static function GetByUuid($uuid, $rememberToken = null){
        if(is_string($uuid) && strlen($uuid) > 20){
            /**
             * @var User $user
             */
            $user = self::where('uuid',$uuid)->first();
            if($rememberToken){
                return $user->getRememberToken() === $rememberToken ? $user : null;
            }else{
                return $user;
            }
        }
        return null;
    }

    /**
     * 根据 电子邮件 获取用户的数据, 如果提供了 $rememberToken 则必须相等
     * @param string $email
     * @param $rememberToken
     * @return null|User
     */
    public static function GetByEmail($email, $rememberToken = null){
        if(is_string($email) && strlen($email) >= 7){
            /**
             * @var User $user
             */
            $user = self::where('email',$email)->first();
            if($rememberToken){
                return $user->getRememberToken() === $rememberToken ? $user : null;
            }else{
                return $user;
            }
        }
        return null;
    }

    /**
     * 获取 Remember Token
     * @return string
     */
    public function getRememberToken(){
        return $this->remember_token;
    }
}