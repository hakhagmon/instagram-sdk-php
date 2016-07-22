<?php

namespace Instagram;

use Instagram\Framework\Exception\CheckpointException;
use Instagram\Framework\Exception\InstagramException;
use Instagram\Framework\Exception\InvalidCredentialsException;
use Instagram\Request\CurrentUserRequest;
use Instagram\Request\FollowUserRequest;
use Instagram\Request\LikeMediaRequest;
use Instagram\Request\LoginRequest;

class Instagram
{
    /**
     *
     * Logged in User
     *
     * @var Response\Model\User
     */
    private $loggedInUser;

    /**
     * User login name
     */
    private $loggedInUsername = null;

    /**
     *
     * Instagram Cookies
     *
     * @var array
     */
    private $cookies;

    /**
     *
     * Instagram CSRF Token
     *
     * @var string
     */
    private $csrfToken;

    /**
     * Realizar login
     * @param $username
     * @param $password
     * @return object
     * @throws CheckpointException
     * @throws InstagramException
     * @throws InvalidCredentialsException
     */
    public function login($username, $password)
    {
        $request = new LoginRequest($this, $username, $password);
        $response = $request->execute();
        
        if ($response->isFail() && $response->isCheckpointRequired()) {
            throw new CheckpointException($response->getMessage(), $response->getCheckpointUrl());
        }
        
        if (!$response->isAuthenticated()) {
            throw new InvalidCredentialsException;
        }

        $this->setLoggedInUsername($response->getUser());

        return $response;
    }

    /**
     * Trazer todos os dados do usuário
     */
    public function getCurrentUser()
    {
        if (is_null($this->getLoggedInUsername())) {
            throw new InstagramException('Você precisa estar logado para fazer esta requisição!');
        }

        $request = new CurrentUserRequest($this);
        $response = $request->execute();

        $this->setLoggedInUser($response);

        return $response;
    }

    /**
     * Save session
     */
    public function saveSession()
    {
        if (is_null($this->getLoggedInUsername())) {
            throw new InstagramException('Você precisa estar logado para fazer esta requisição!');
        }

        $data = [
            'user' => [
                'id' => $this->loggedInUser->getId(),
                'username' => $this->loggedInUser->getUsername(),
            ],
            'cookies' => $this->getCookies()
        ];

        return json_encode($data);
    }

    /**
     * Init from session
     * @param $serializedSession
     * @throws InstagramException
     * @throws \Exception
     */
    public function initFromSession($serializedSession)
    {
        $session = json_decode($serializedSession);
        if (is_null($session)) {
            throw new \Exception('A sessão tem que ser um JSON válido!');
        }

        if (!(isset($session->user) && isset($session->cookies))) {
            throw new InstagramException('Essa sessão não é válida!');
        }

        $this->setLoggedInUsername($session->user->username);
        $this->setCookies((array) $session->cookies);
    }

    /**
     * Follow user
     * @param $userId
     * @return object
     * @throws InstagramException
     */
    public function followUser($userId)
    {
        if (is_null($this->getLoggedInUsername())) {
            throw new InstagramException('Você precisa estar logado para fazer esta requisição!');
        }

        $request = new FollowUserRequest($this, $userId);
        $response = $request->execute();

        return $response;
    }

    /**
     * Like media
     * @param $mediaId
     * @return object
     * @throws InstagramException
     */
    public function likeMedia($mediaId)
    {
        if (is_null($this->getLoggedInUsername())) {
            throw new InstagramException('Você precisa estar logado para fazer esta requisição!');
        }

        $request = new LikeMediaRequest($this, $mediaId);
        $response = $request->execute();

        return $response;
    }

    /**
     * @return array
     */
    public function getCookies(){
        return is_array($this->cookies) ? $this->cookies : array();
    }

    /**
     * @param array $cookies
     */
    public function setCookies($cookies){
        $this->cookies = $cookies;
        if(array_key_exists("csrftoken", $cookies)){
            $this->setCsrfToken($cookies["csrftoken"]);
        }
    }

    /**
     * @param string $csrfToken
     */
    public function setCsrfToken($csrfToken){
        $this->csrfToken = $csrfToken;
    }

    /**
     * @return string
     */
    public function getCSRFToken(){
        return $this->csrfToken;
    }

    /**
     * @return Response\Model\User
     */
    public function getLoggedInUser()
    {
        return $this->loggedInUser;
    }

    /**
     * @param Response\Model\User $loggedInUser
     */
    public function setLoggedInUser($loggedInUser)
    {
        $this->loggedInUser = $loggedInUser;
    }

    /**
     * @return mixed
     */
    public function getLoggedInUsername()
    {
        return $this->loggedInUsername;
    }

    /**
     * @param mixed $loggedInUsername
     */
    public function setLoggedInUsername($loggedInUsername)
    {
        $this->loggedInUsername = $loggedInUsername;
    }
}