<?php
require_once __DIR__ . '/../vendor/autoload.php';

use MelodyMbewe\InvestecApiWrapper\Client;
use Dotenv\Dotenv;

function runTest($name, callable $test) {
    echo "\n🎄 Testing: $name\n";
    try {
        $test();
        echo "✅ Passed!\n";
    } catch (\Exception $e) {
        echo "❌ Failed: " . $e->getMessage() . "\n";
        echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    }
}

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../config');
$dotenv->load();

$client = new Client(
    $_ENV['CLIENT_ID'],
    $_ENV['CLIENT_SECRET'],
    $_ENV['API_KEY'],
    $_ENV['BASE_URL_PRIVATE_BANKING'],
    $_ENV['BASE_URL_ICIB'],
    new InvestecOAuth(
        $_ENV['CLIENT_ID'],
        $_ENV['CLIENT_SECRET'],
        $_ENV['API_KEY']
    )
);

// Private Banking Tests
runTest('Private Banking - Get Accounts', function() use ($client) {
    $accounts = $client->getPrivateBankingAccounts();
    assert(!empty($accounts['data']['accounts']), 'No accounts returned');
});

runTest('Private Banking - Get Balance', function() use ($client) {
    $accounts = $client->getPrivateBankingAccounts();
    $accountId = $accounts['data']['accounts'][0]['accountId'];
    $balance = $client->getPrivateBankingBalance($accountId);
    assert(isset($balance['data']['balance']), 'No balance returned');
});

// ICIB Tests
runTest('ICIB - Get Accounts', function() use ($client) {
    $accounts = $client->getICIBAccounts();
    assert(!empty($accounts['data']['accounts']), 'No ICIB accounts returned');
});

// Rate Limiting Test
runTest('Rate Limiting', function() use ($client) {
    for ($i = 0; $i < 5; $i++) {
        $client->getPrivateBankingAccounts();
        usleep(500000); // Wait 0.5 seconds between requests
    }
});