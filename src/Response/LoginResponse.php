<?php

namespace Instagram\Response;

class LoginResponse extends BaseResponse
{
    /**
     * Authenticated?
     * @var boolean
     */
    protected $authenticated;

    /**
     * Username
     */
    protected $user;

    /**
     * @return boolean
     */
    public function isAuthenticated()
    {
        return $this->authenticated;
    }

    /**
     * @param boolean $authenticated
     */
    public function setAuthenticated($authenticated)
    {
        $this->authenticated = $authenticated;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}