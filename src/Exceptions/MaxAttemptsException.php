<?php

namespace TimYouri\CustomId\Exceptions;

use Throwable;

class MaxAttemptsException extends \RuntimeException
{
    protected $message = "Max attempts (%s) for generating custom ID reached.";

    public function __construct(int $attempts, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf($this->message, $attempts), $code, $previous);
    }
}
