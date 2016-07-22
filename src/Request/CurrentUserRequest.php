<?php

namespace Instagram\Request;

use Instagram\Framework\Constant\RequestConstants;
use Instagram\Response\CurrentUserResponse;
use Instagram\Response\LoginResponse;
use Instagram\Response\Model\Model;
use Instagram\Response\Model\User;

class CurrentUserRequest extends BaseRequest
{
    /**
     * LoginRequest constructor.
     * @param $instagram
     */
    public function __construct($instagram)
    {
        parent::__construct($instagram);
    }

    public function getResponseObject()
    {
        return new User;
    }

    public function getMethod()
    {
        return RequestConstants::GET;
    }

    public function getEndpoint()
    {
        return "/" . $this->instagram->getLoggedInUsername();
    }

    public function throwExceptionIfResponseNotOk(){
        return false;
    }

    public function parseResponse($response)
    {
        preg_match_all('/window._sharedData = (.*?);<\/script>/is', $response->getData(), $matches);

        $json = json_decode($matches[1][0]);
        $user = $json->entry_data->ProfilePage[ 0 ]->user;

        $userObject = $this->mapper->map($user, $this->getResponseObject());
        $userObject->setFollowersCount($user->follows->count);
        $userObject->setFollowingCount($user->followed_by->count);

        // account
        $request = new EditAccountRequest($this->instagram);
        $response = $request->execute();

        $userObject->setGender($response->gender);
        $userObject->setEmail($response->email);

        return $userObject;
    }
}