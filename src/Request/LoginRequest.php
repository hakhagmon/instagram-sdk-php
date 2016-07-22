<?php

namespace Instagram\Request;

use Instagram\Framework\Constant\RequestConstants;
use Instagram\Response\LoginResponse;

class LoginRequest extends BaseRequest
{
    /**
     * LoginRequest constructor.
     * @param $username
     * @param $password
     */
    public function __construct($instagram, $username, $password)
    {
        parent::__construct($instagram);

        $this->addHeader('X-CSRFToken', '459aMffKwq1CD5hhRxaEzGo53yXu1GAQ');
        $this->addCookie('csrftoken', '459aMffKwq1CD5hhRxaEzGo53yXu1GAQ');
        $this->setParams([
            'username' => $username,
            'password' => $password
        ]);
    }

    public function getResponseObject()
    {
        return new LoginResponse;
    }

    public function getMethod()
    {
        return RequestConstants::POST;
    }

    public function getEndpoint()
    {
        return "/accounts/login/ajax/";
    }

    public function throwExceptionIfResponseNotOk(){
        return false;
    }

    public function authenticated() {
        return false;
    }
}