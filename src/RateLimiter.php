<?php

namespace MelodyMbewe\InvestecApiWrapper;

class RateLimiter
{
    private $requests = [];
    private $limit;
    private $window;

    public function __construct(int $limit = 100, int $window = 60)
    {
        $this->limit = $limit;
        $this->window = $window;
    }

    public function throttle(): void
    {
        $this->clearOldRequests();
        
        if (count($this->requests) >= $this->limit) {
            throw new \RuntimeException(
                sprintf('Rate limit of %d requests per %d seconds exceeded', $this->limit, $this->window)
            );
        }
        
        $this->requests[] = time();
    }

    private function clearOldRequests(): void
    {
        $threshold = time() - $this->window;
        $this->requests = array_filter($this->requests, function($timestamp) use ($threshold) {
            return $timestamp > $threshold;
        });
    }
} 