<?php

namespace App\Api\v1\Exceptions;

use Exception;

class BotMessageException extends Exception
{
    /**
     * @var int
     */
    protected $code = 500;

    /**
     * UnsupportedStatusKeyException constructor.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct();
        $this->message = $message;
    }
}
