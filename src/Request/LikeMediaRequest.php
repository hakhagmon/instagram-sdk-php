<?php

namespace Instagram\Request;

use Instagram\Framework\Constant\RequestConstants;
use Instagram\Instagram;
use Instagram\Response\FollowUserResponse;
use Instagram\Response\LikeMediaResponse;
use Instagram\Response\LoginResponse;

class LikeMediaRequest extends BaseRequest
{
    /**
     * @var string Destination user to follow
     */
    protected $mediaId;

    /**
     * FollowUserRequest constructor.
     * @param Instagram $instagram
     * @param $mediaId
     */
    public function __construct($instagram, $mediaId)
    {
        parent::__construct($instagram);
        $this->addHeader('x-instagram-ajax', '1');
        $this->addHeader('x-requested-with', 'XMLHttpRequest');
        $this->mediaId = $mediaId;
    }

    public function getResponseObject()
    {
        return new LikeMediaResponse();
    }

    public function getMethod()
    {
        return RequestConstants::POST;
    }

    public function getEndpoint()
    {
        return "/web/likes/{$this->mediaId}/like/";
    }

    public function throwExceptionIfResponseNotOk(){
        return true;
    }
}