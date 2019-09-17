<?php

namespace AppModels;

use Illuminate\Database\Eloquent\Model;

/**
 * 学校表
 */
class School extends Model
{
    protected $table = 't_api_school';


    /**
     * 获取 getSchoolName
     * @return string
     */
    public function getSchoolName() {
        return $this->school_name;
    }

    /**
     * 获取 getSchoolMotto
     * @return string
     */
    public function getSchoolMotto() {
        return $this->school_motto;
    }


    /**
     * 获取 getSchoolLogo
     * @return string
     */
    public function getSchoolLogo() {
        return $this->school_img;
    }

    /**
     * 获取 getSchoolVideo
     * @return string
     */
    public function getSchoolVideo() {
        return $this->school_video;
    }

    public function cloudJson()
    {
        return [
            'school' => [
                   'name'  => $this->getSchoolName(),
                   'motto' => $this->getSchoolMotto(),
                   'logo' => [
                             'path' => $this->getSchoolLogo(),
                             'size' => '',
                             'type' => '',
                   ]
            ]
        ];
    }
}