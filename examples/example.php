<?php
require_once __DIR__ . '/../vendor/autoload.php';

use MelodyMbewe\InvestecApiWrapper\Client;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../config');
$dotenv->load();

// Initialize client
$client = new Client(
    $_ENV['CLIENT_ID'],
    $_ENV['CLIENT_SECRET'],
    $_ENV['API_KEY'],
    $_ENV['BASE_URL_PRIVATE_BANKING'],
    $_ENV['BASE_URL_ICIB']
);

$authorizationUrl = $client->getAuthorizationUrl('http://localhost:8080/callback');
echo "Visit this URL to authorize: $authorizationUrl\n";

// Private Banking Examples
echo "=== Private Banking Examples ===\n";

$privateBankingAccounts = $client->getPrivateBankingAccounts();
print_r($privateBankingAccounts);

$accountId = $privateBankingAccounts['data']['accounts'][0]['accountId'];
$balance = $client->getPrivateBankingBalance($accountId);
print_r($balance);

$transactions = $client->getPrivateBankingTransactions($accountId, '2024-01-01', '2024-01-31');
print_r($transactions);

// ICIB Examples
echo "\n=== ICIB Examples ===\n";

$icibAccounts = $client->getICIBAccounts();
print_r($icibAccounts);

$icibAccountId = $icibAccounts['data']['accounts'][0]['accountId'];
$icibBalance = $client->getICIBBalance($icibAccountId);
print_r($icibBalance);

$icibTransactions = $client->getICIBTransactions($icibAccountId, '2024-01-01', '2024-01-31');
print_r($icibTransactions);