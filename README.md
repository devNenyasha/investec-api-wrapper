# 🎄 Investec API Wrapper: Your Festive Helper! 🎁

A delightfully simple PHP wrapper for Investec's Private Banking and ICIB APIs. This wrapper simplifies API integration, handles authentication seamlessly, and empowers developers to build festive solutions! 🎅

## 🎁 Features at a Glance

Dear Santa, I want an API wrapper that:
- 🎁 Works with both Private Banking and ICIB
- 🎅 Handles OAuth automatically
- 🦌 Simple, fluent interface
- 🔒 Built-in error handling
- 🔄 Automatic token refresh
- ⚡ Rate limiting with backoff
- 🎨 Has clear examples

## 🎄 Quick Start

### Prerequisites
Make sure you have:
- [PHP 7.4 or higher](https://www.php.net/downloads.php) - Download and install PHP
- [Composer](https://getcomposer.org/download/) - Download and install Composer
- [Docker](https://www.docker.com/products/docker-desktop/) - Download and install Docker


### Installation

#### Set Up the Sandbox (for testing)

1. Clone the sandbox repository:
```bash
git clone https://github.com/devinpearson/programmable-banking-sim.git
cd programmable-banking-sim
npm install
```

2. Run the server in a Docker container:
```bash
docker build -t investec-sim .
docker run -p 3000:3000 investec-sim
```

3. Start the simulator:
```bash
npm run dev
```
Your sandbox will run at http://localhost:3000


#### Install the wrapper

1. Install the wrapper via Composer:
```bash
composer require melodymbewe/investec-api-wrapper
```

### Step 2: Create Configuration
Create a `.env` file in your project's root:
```bash
CLIENT_ID=your-client-id
CLIENT_SECRET=your-client-secret
API_KEY=your-api-key
BASE_URL_PRIVATE_BANKING=https://api.investec.com/za/pb/v1
BASE_URL_ICIB=https://api.investec.com/za/icib/v1
```

### Step 3: Create your client:
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

## 🧪 Running Comprehensive Tests

For a full test of all features, use the provided test script:
```bash
php run-test.php
```

## 🔍 Troubleshooting

If you encounter errors:
1. Check your credentials in `.env`
2. Ensure you have the required PHP extensions:
   ```bash
   php -m | grep -E "curl|json|openssl"
   ```
3. Verify your PHP version:

   ```bash
   php -v
   ```

For detailed examples, see:

```php:investec-api-wrapper/examples/example.php
startLine: 1
endLine: 47
```
##📝 License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

### 🚀 Resources
- [Stateful Sandbox Documentation](https://developer.investec.com/za/api-products/stateful-sandbox)
- [Wrapper Documentation](https://github.com/melodyMbewe/investec-api-wrapper/wiki)

🎄 A Festive Note
This project is a mock environment, perfect for testing and developing your next big idea. Let’s make this season brighter with amazing tech! ✨
