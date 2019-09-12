<?php
/**
 * 请求数据的基类
 */

namespace AppServices\requests;

class BasicRequest
{
    protected $data = [];
    protected $files = null;

    // 请求的类型
    private $type = 0;

    public function __construct(\Yaf_Request_Http $request, $type)
    {
        if($request->getMethod() === 'POST'){
            $this->data = $request->getPost();
            $this->files = $request->getFiles();
        }else{
            $this->data = $request->getParams();
        }
        $this->type = $type;
    }

    /**
     * 获取版本
     * @return string|null
     */
    public function getVersion(){
        return $this->get('version');
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