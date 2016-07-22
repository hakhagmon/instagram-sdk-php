<?php

namespace Instagram\Request;

use Instagram\Framework\Constant\RequestConstants;
use Instagram\Framework\Exception\InstagramException;
use Instagram\Framework\Request;
use Instagram\Response\LoginResponse;

abstract class BaseRequest extends Request
{
    /**
     * @var Instagram
     */
    public $instagram;

    /**
     * @var Response The Response Object
     */
    private $response;

    /**
     * BaseRequest constructor.
     */
    public function __construct($instagram)
    {
        parent::__construct();

        $this->setHeaders([
            'User-Agent' => RequestConstants::USERAGENT,
            'Origin' => RequestConstants::BASE_URL,
            'Referer' => RequestConstants::BASE_URL,
            'upgrade-insecure-requests' => '1',
        ]);

        if ($this->authenticated()) {
            $this->setCookies($instagram->getCookies());
            $this->addHeader('X-CSRFToken', $instagram->getCSRFToken());
        }

        $this->setInstagram($instagram);
    }

    /**
     * @return string The API Endpoint
     */
    public abstract function getEndpoint();

    /**
     * @param $instagram Instagram Instagram Instance to use for this Request
     */
    public function setInstagram($instagram){
        $this->instagram = $instagram;
    }

    /**
     * @return string Full url
     */
    public function getUrl()
    {
        return RequestConstants::BASE_URL . $this->getEndpoint();
    }

    public function throwExceptionIfResponseNotOk(){
        return true;
    }

    public function parseResponse($response)
    {
        return $this->mapper->map($response->getData(), $this->getResponseObject());
    }

    public function authenticated() {
        return true;
    }

    /**
     *
     * Execute the Request
     *
     * @return object Response Data
     * @throws InstagramException
     */
    public function execute()
    {
        $response = parent::execute();
        $this->response = $response;

        if ($this->throwExceptionIfResponseNotOk() && !$response->isOK())
        {
            throw new InstagramException(sprintf("Instagram Request Failed! [%s] [%s]", $this->getEndpoint(), $response->getCode()));
        }

        $this->instagram->setCookies(array_merge($this->instagram->getCookies(), $response->getCookies()));

        return $this->parseResponse($response);
    }
}