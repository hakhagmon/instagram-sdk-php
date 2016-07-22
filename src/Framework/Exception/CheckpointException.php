<?php

namespace Instagram\Framework\Exception;

class CheckpointException extends \Exception
{
    /**
     * Url para checkpoint
     * @var string
     */
    private $checkpointUrl = null;

    /**
     * CheckpointException constructor.
     * @param string $message
     * @param int $url
     */
    public function __construct($message, $url)
    {
        parent::__construct($message);
        $this->checkpointUrl = $url;
    }

    /**
     * Recuperar a url de checkpoint
     * @return int
     */
    public function getCheckpointUrl()
    {
        return $this->checkpointUrl;
    }
}