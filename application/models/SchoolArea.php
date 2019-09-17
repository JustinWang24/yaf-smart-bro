<?php

namespace AppModels;

use Illuminate\Database\Eloquent\Model;

/**
 * 分校表
 */
class SchoolArea extends Model
{
	protected $table = 't_api_school_area';


    /**
     * 获取 getSchoolVideo
     * @return string
     */
    public function getSchoolAreaVideo() {
        return $this->school_video;
    }

    public function cloudAreaJson()
    {
        return [
            'area'  => [
                    'video' => $this->getSchoolAreaVideo(),
                    'size'  => '',
                    'type'  => ''
            ]
        ];
    }


}