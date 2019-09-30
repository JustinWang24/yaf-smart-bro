<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 3/9/19
 * Time: 3:35 PM
 */
namespace AppServices\responses;

abstract class BasicResponse
{
    const ERROR_CODE_OK                          = 1000; // 一切正常

    protected $data = null;
    protected $code;    // 状态码
    protected $message; // 消息

    protected $errors = [];

    public function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = [
            'data'=>[]
        ];
        $this->setCode($code);
    }

    /**
     * 将最终的结果以 json 的格式返回
     * @return string
     */
    public function toJson(){
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }

    public function setCode($code){
        $this->code = $code;
        $this->data['code'] = $code;
        $this->setMessage($this->errors[$code] ?? '');
    }

    public function setMessage($msg){
        $this->message = $msg;
        $this->data['message'] = $msg;
    }

    /**
     * 将需要传递的消息体数据放到正确的位置
     * @param $data
     * @return $this
     */
    public function setMessageBag($data){
        $this->data['data'] = $data;
        return $this;
    }

    /**
     * 将最终的结果以 array 数组的格式返回
     * 这个方法的存在, 可以让测试更加方便
     * @return array
     */
    public abstract function toArray();
}