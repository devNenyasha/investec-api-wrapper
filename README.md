# 🎄 Investec API Wrapper

A comprehensive PHP wrapper for Investec's Private Banking and ICIB APIs.

Dear Santa, I want an API wrapper that:
- 🎁 Works with both Private Banking and ICIB
- 🎅 Handles OAuth automagically
- 🦌 Is easy to use
- 🎨 Has clear examples

## 🎄 Installation

```bash
composer require melodymbewe/investec-api-wrapper
```
## 🎁 Quick Start

```php
use MelodyMbewe\InvestecApiWrapper\Client;
// Initialize the client
$client = new Client(
'your-client-id',
'your-client-secret',
'your-api-key',
'https://api.investec.com/za/pb/v1', // Private Banking endpoint
'https://api.investec.com/za/icib/v1' // ICIB endpoint
);
// Private Banking Magic 🎁
$accounts = $client->getPrivateBankingAccounts();
$balance = $client->getPrivateBankingBalance($accountId);
// ICIB Magic 🎅
$corporateAccounts = $client->getICIBAccounts();
$corporateBalance = $client->getICIBBalance($accountId);
```

## 🎅 Features

### 🎁 1. Private Banking API
- Account Management
  - List accounts
  - Get account balances
  - View transactions
- Card Services
  - View card details
  - Get card transactions
- Payments
  - Make transfers
  - Schedule payments

### 🎁  2. ICIB (Corporate) API
- Account Management
  - List corporate accounts
  - Get account balances
  - View transactions
- Bulk Payments
  - Process multiple payments
  - Payment status tracking

### 🦌 3. OAuth Implementation
- Automatic token management
- Smart token refresh
- Zero configuration needed
- Secure credential handling
- Token caching

## 🎨 Contributing
Contributions are welcome! Please read our contributing guidelines.

## 📝 License
MIT License

## 🦌 OAuth Magic
- Automatic token management
- Smart token refresh
- Zero-hassle authentication

## 🔄 Retry Logic

- Automatic retry on token expiration
- Configurable retry attempts
- Exponential backoff

## 🔒 Rate Limiting

The wrapper implements automatic rate limiting with exponential backoff:
- 100 requests per minute by default
- Configurable limits
- Automatic retry with backoff

## 🚨 Error Handling

Comprehensive error handling with detailed information:
- OAuth errors (401, 403)
- Rate limiting (429)
- API-specific errors
- Network timeouts
- Validation errors

Each error includes:
- Detailed message
- Error code
- Suggested resolution
- Stack trace (in debug mode)
