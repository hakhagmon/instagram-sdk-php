<?php

namespace Instagram\Framework;

use Curl\Curl;
use Instagram\Framework\Constant\RequestConstants;
use Instagram\Framework\Exception\RequestException;

abstract class Request
{
    /**
     * Used for Mapping response Json to Class instances.
     * @var JsonMapper
     */
    public $mapper;

    /**
     * Verify peer?
     * @var boolean
     */
    private $verifyPeer = false;

    /**
     * Params
     * @var array params
     */
    private $params = [];

    /**
     * Headers
     * @var array headers
     */
    private $headers = [];

    /**
     * Cookies
     * @var array cookies
     */
    private $cookies = [];

    /**
     * @return string Get method
     */
    public abstract function getMethod();

    /**
     * @return string Get request url
     */
    public abstract function getUrl();

    /**
     * Request constructor.
     */
    public function __construct(){
        $this->mapper = new \JsonMapper();
    }

    /**
     * @return mixed
     */
    public function getVerifyPeer()
    {
        return $this->verifyPeer;
    }

    /**
     * @param mixed $verifyPeer
     */
    public function setVerifyPeer($verifyPeer)
    {
        $this->verifyPeer = $verifyPeer;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addCookie($key, $value)
    {
        $this->cookies[$key] = $value;
    }

    /**
     * @return mixed
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @param mixed $cookies
     */
    public function setCookies($cookies)
    {
        $this->cookies = $cookies;
    }

    public function execute()
    {
        $curl = new Curl();
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, $this->verifyPeer);
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST, $this->verifyPeer);
        $curl->setOpt(CURLOPT_FOLLOWLOCATION, true);

        foreach ($this->getHeaders() as $key => $value)
        {
            $curl->setHeader($key, $value);
        }
        foreach ($this->getCookies() as $key => $value)
        {
            $curl->setCookie($key, $value);
        }

        switch ($this->getMethod())
        {
            case RequestConstants::GET:
                $data = $curl->get($this->getUrl());
                break;

            case RequestConstants::POST:
                $data = $curl->post($this->getUrl(), $this->getParams());
                break;
        }

        if ($curl->curlError) {
            throw new RequestException($curl->curlErrorMessage, $curl->curlErrorCode);
        }
        
        return new Response($curl, $data);
    }
}