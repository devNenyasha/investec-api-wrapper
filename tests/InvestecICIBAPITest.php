<?php

namespace MelodyMbewe\InvestecApiWrapper\Tests;

use PHPUnit\Framework\TestCase;
use MelodyMbewe\InvestecApiWrapper\Client;
use MelodyMbewe\InvestecApiWrapper\Tests\Mocks\MockOAuth;

class InvestecICIBAPITest extends TestCase
{
    use MockOAuth;
    
    private $client;
    
    protected function setUp(): void
    {
        $this->client = $this->getMockBuilder(Client::class)
            ->setConstructorArgs([
                'test-client-id',
                'test-client-secret',
                'test-api-key',
                'http://localhost:3000/za/pb/v1',
                'http://localhost:3000/za/icib/v1'
            ])
            ->onlyMethods(['getAccessToken'])
            ->getMock();

        $this->client->method('getAccessToken')
            ->willReturn($this->mockAccessToken());
    }

    public function testGetICIBAccounts()
    {
        $accounts = $this->client->getICIBAccounts();
        
        $this->assertIsArray($accounts);
        $this->assertArrayHasKey('data', $accounts);
        $this->assertArrayHasKey('accounts', $accounts['data']);
    }

    public function testGetICIBTransactions()
    {
        $transactions = $this->client->getICIBTransactions(
            '4675778129910189600000003',
            '2022-11-01'
        );
        
        $this->assertIsArray($transactions);
        $this->assertArrayHasKey('data', $transactions);
        $this->assertArrayHasKey('transactions', $transactions['data']);
    }
}