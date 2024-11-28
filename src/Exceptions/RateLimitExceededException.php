<?php

namespace MelodyMbewe\InvestecApiWrapper\Exceptions;

class RateLimitExceededException extends \RuntimeException
{
    private $retryAfter;

    public function __construct(string $message, int $retryAfter)
    {
        parent::__construct($message);
        $this->retryAfter = $retryAfter;
    }

    public function getRetryAfter(): int
    {
        return $this->retryAfter;
    }
}