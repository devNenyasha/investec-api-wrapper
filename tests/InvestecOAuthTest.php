<?php

namespace MelodyMbewe\InvestecApiWrapper\Tests;

use PHPUnit\Framework\TestCase;
use MelodyMbewe\InvestecApiWrapper\Client;
use MelodyMbewe\InvestecApiWrapper\InvestecOAuth;
use MelodyMbewe\InvestecApiWrapper\Tests\Mocks\MockOAuth;

class InvestecOAuthTest extends TestCase
{
    use MockOAuth;
    
    private $oauth;
    
    protected function setUp(): void
    {
        $this->oauth = $this->getMockBuilder(InvestecOAuth::class)
            ->setConstructorArgs([
                'test-client-id',
                'test-client-secret',
                'test-api-key'
            ])
            ->onlyMethods(['getAccessTokenUsingClientCredentials'])
            ->getMock();

        $this->oauth->method('getAccessTokenUsingClientCredentials')
            ->willReturn($this->mockAccessToken()['access_token']);
    }

    public function testGetAccessToken()
    {
        $token = $this->oauth->getAccessTokenUsingClientCredentials();
        $this->assertEquals('mock-access-token', $token);
    }
}
