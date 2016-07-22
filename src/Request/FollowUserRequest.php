<?php

namespace Instagram\Request;

use Instagram\Framework\Constant\RequestConstants;
use Instagram\Instagram;
use Instagram\Response\FollowUserResponse;
use Instagram\Response\LoginResponse;

class FollowUserRequest extends BaseRequest
{
    /**
     * @var string Destination user to follow
     */
    protected $userId;

    /**
     * FollowUserRequest constructor.
     * @param Instagram $instagram
     * @param $userId
     */
    public function __construct($instagram, $userId)
    {
        parent::__construct($instagram);
        $this->addHeader('x-instagram-ajax', '1');
        $this->addHeader('x-requested-with', 'XMLHttpRequest');
        $this->userId = $userId;
    }

    public function getResponseObject()
    {
        return new FollowUserResponse();
    }

    public function getMethod()
    {
        return RequestConstants::POST;
    }

    public function getEndpoint()
    {
        return "/web/friendships/{$this->userId}/follow/";
    }

    public function throwExceptionIfResponseNotOk(){
        return true;
    }
}