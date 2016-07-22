<?php

namespace Instagram\Request;

use Instagram\Framework\Constant\RequestConstants;
use Instagram\Framework\Exception\InstagramException;
use Instagram\Response\CurrentUserResponse;
use Instagram\Response\LoginResponse;

class EditAccountRequest extends BaseRequest
{
    /**
     * EditAccountRequest constructor.
     * @param $instagram
     */
    public function __construct($instagram)
    {
        parent::__construct($instagram);
    }

    public function getResponseObject()
    {
        return null;
    }

    public function getMethod()
    {
        return RequestConstants::GET;
    }

    public function getEndpoint()
    {
        return "/accounts/edit/";
    }

    public function throwExceptionIfResponseNotOk(){
        return false;
    }

    public function parseResponse($response)
    {
        preg_match_all('/window._sharedData = (.*?);<\/script>/is', $response->getData(), $matches);

        $json = json_decode($matches[1][0]);

        if (!isset($json->entry_data->SettingsPages[0]->form_data)) {
            throw new InstagramException('login_required');
        }
        $settings = $json->entry_data->SettingsPages[0]->form_data;

        $userSettings = new \stdClass();
        $userSettings->gender = $settings->gender;
        $userSettings->email = $settings->email;

        return $userSettings;
    }
}