<?php

use AppModels\School;
use AppModels\SchoolCloud;
use AppServices\requests\RequestFactory;
use AppServices\responses\CloudBanCardResponse;
use AppServices\responses\ResponseFactory;
use AppServices\utils\CloudBanCard;

class CloudBanCardController extends Yaf_Controller_Abstract 
{

	/**
	 * 获取学校信息
	 */
	public function getSchoolInfoAction()
	{
		$request = RequestFactory::GetCloudBanCardRequest($this->getRequest());

        /**
         * @var CloudBanCardResponse $response
         */
        $response = ResponseFactory::GetInstance(
            $request->getType(),
            CloudBanCard::ERROR_CODE_OK,
            CloudBanCard::GetErrorMessage(CloudBanCard::ERROR_CODE_OK)
        );

        /**
         * @var SchoolCloud|null $schoolCloud
         */
		$schoolCloud = CloudBanCard::GetSchoolByCode($request->getCode());  # 根据code 获取学校信息

        if (is_object($schoolCloud)) {

            // 学校信息
            $schoolInfo = CloudBanCard::GetSchoolInfo($schoolCloud);
            // 分校信息
            $schoolAreaInfo = CloudBanCard::GetSchoolAreaInfo($schoolCloud);

            $response->prepareData($schoolInfo, $schoolAreaInfo);
        } else {
            $response->setCode($schoolCloud);
            $response->setMessage(CloudBanCard::GetErrorMessage($schoolCloud));
        }

        echo $response->toJson();
		return false;
	}	



}