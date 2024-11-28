<?php

require_once __DIR__ . '/vendor/autoload.php';

use MelodyMbewe\InvestecApiWrapper\Client;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/config');
$dotenv->load();

try {
    $client = new Client(
        $_ENV['CLIENT_ID'],
        $_ENV['CLIENT_SECRET'],
        $_ENV['API_KEY'],
        'http://localhost:3000/za/pb/v1',
        'http://localhost:3000/za/icib/v1'
    );

    // Get accounts with error handling
    try {
        $accounts = $client->getPrivateBankingAccounts();
        echo "Private Banking Accounts:\n";
        print_r($accounts);

        if (empty($accounts['data']['accounts'])) {
            throw new \RuntimeException('No accounts found');
        }

        $accountId = $accounts['data']['accounts'][0]['accountId'];
        
        // Get balance
        $balance = $client->getPrivateBankingBalance($accountId);
        echo "\nAccount Balance:\n";
        print_r($balance);

        // Get transactions
        $transactions = $client->getPrivateBankingTransactions($accountId, '2022-11-01');
        echo "\nTransactions:\n";
        print_r($transactions);
    } catch (\RuntimeException $e) {
        echo "API Error: " . $e->getMessage() . "\n";
    }
} catch (\Exception $e) {
    echo "System Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}