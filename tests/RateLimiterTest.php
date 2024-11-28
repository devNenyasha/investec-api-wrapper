<?php

namespace MelodyMbewe\InvestecApiWrapper\Tests;

use PHPUnit\Framework\TestCase;
use MelodyMbewe\InvestecApiWrapper\RateLimiter;

class RateLimiterTest extends TestCase
{
    private $rateLimiter;

    protected function setUp(): void
    {
        $this->rateLimiter = new RateLimiter(2, 1);
    }

    public function testRespectRateLimit()
    {
        $this->rateLimiter->throttle();
        $this->rateLimiter->throttle();
        
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Rate limit of 2 requests per 1 seconds exceeded');
        
        $this->rateLimiter->throttle();
    }

    public function testWindowReset()
    {
        $this->rateLimiter->throttle();
        $this->rateLimiter->throttle();
        
        sleep(2); 
        
        $this->rateLimiter->throttle();
        $this->assertTrue(true);
    }
}
