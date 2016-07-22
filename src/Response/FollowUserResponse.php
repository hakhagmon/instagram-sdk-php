<?php

namespace Instagram\Response;

class FollowUserResponse extends BaseResponse
{
    /**
     * Result
     * @var string
     */
    protected $result;

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param string $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }
}