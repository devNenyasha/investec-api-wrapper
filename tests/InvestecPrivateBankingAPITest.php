<?php

namespace MelodyMbewe\InvestecApiWrapper\Tests;

use PHPUnit\Framework\TestCase;
use MelodyMbewe\InvestecApiWrapper\Client;

class InvestecPrivateBankingAPITest extends TestCase
{
    private $client;
    
    protected function setUp(): void
    {
        $config = [
            'client_id' => 'test-client-id',
            'client_secret' => 'test-client-secret', 
            'api_key' => 'test-api-key',
            'certificate' => '/path/to/test/certificate.pem',
            'private_key' => '/path/to/test/private_key.pem'
        ];

        $this->client = new Client($config);
    }

    public function testGetAccounts()
    {
        $accounts = $this->client->getPrivateBankingAccounts();
        
        $this->assertIsArray($accounts);
        $this->assertArrayHasKey('data', $accounts);
        $this->assertArrayHasKey('accounts', $accounts['data']);
        
        // Test against known test data from accounts.json
        $this->assertEquals('4675778129910189600000006', $accounts['data']['accounts'][3]['accountId']);
        $this->assertEquals('10012420006', $accounts['data']['accounts'][3]['accountNumber']);
        $this->assertEquals('Mr J Soap', $accounts['data']['accounts'][3]['accountName']);
        $this->assertEquals('Mortgage Loan Account', $accounts['data']['accounts'][3]['productName']);
    }

    public function testGetBalance()
    {
        $balance = $this->client->getPrivateBankingBalance('4675778129910189600000003');
        
        $this->assertIsArray($balance);
        $this->assertArrayHasKey('data', $balance);
        $this->assertEquals('4675778129910189600000003', $balance['data']['accountId']);
        $this->assertArrayHasKey('currentBalance', $balance['data']);
        $this->assertArrayHasKey('availableBalance', $balance['data']);
        $this->assertEquals('ZAR', $balance['data']['currency']);
    }

    public function testGetTransactions()
    {
        $transactions = $this->client->getPrivateBankingTransactions(
            '4675778129910189600000003',
            '2022-11-01'
        );
        
        $this->assertIsArray($transactions);
        $this->assertArrayHasKey('data', $transactions);
        $this->assertArrayHasKey('transactions', $transactions['data']);
        
        // Test first transaction from the test data
        $firstTransaction = $transactions['data']['transactions'][0];
        $this->assertEquals('4675778129910189600000003', $firstTransaction['accountId']);
        $this->assertEquals('DEBIT', $firstTransaction['type']);
        $this->assertEquals('CardPurchases', $firstTransaction['transactionType']);
        $this->assertEquals('POSTED', $firstTransaction['status']);
        $this->assertEquals('HTTP://WWW.UBEREATS.CO PARKTOWN NOR ZA', $firstTransaction['description']);
    }
}
