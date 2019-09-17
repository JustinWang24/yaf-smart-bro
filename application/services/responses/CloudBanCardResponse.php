<?php

namespace AppServices\responses;
use AppModels\School;
use AppModels\SchoolCloud;

class CloudBanCardResponse extends BasicResponse
{
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @param $schoolInfo
     * @param $schoolAreaInfo
     * @return BasicResponse
     */
    public function prepareData($schoolInfo, $schoolAreaInfo){
        $this->data['data']  = array_merge(
            $schoolInfo->cloudJson(),
            $schoolAreaInfo->cloudAreaJson()
        );
        return $this;
    }
}