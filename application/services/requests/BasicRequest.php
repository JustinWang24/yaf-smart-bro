<?php
/**
 * 请求数据的基类
 */

namespace AppServices\requests;

class BasicRequest
{
    protected $data = [];

    // 请求的类型
    private $type = 0;

    public function __construct(\Yaf_Request_Abstract $request, $type)
    {
        if($request->getMethod() === 'POST'){
            $this->data = $request->getPost();
        }else{
            $this->data = $request->getParams();
        }
        $this->type = $type;
    }

    /**
     * 获取请求的类型整数值
     * @return int
     */
    public function getType(){
        return $this->type;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    protected function get($key){
        return $this->data[$key] ?? null;
    }
}