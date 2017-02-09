# CS-API

Library to access Ceska sporitelna Netbanking V3 API
 
## Summary

- [Requirements and dependencies](#requirements-and-dependencies)
- [Installation](#installation)
- [Usage](#usage)
 
## Licence

GPL-3.0+

## Requirements and dependencies

- "php": ">=5.6.0"
- "league/oauth2-client": "^2.2"

## Installation

Go to your web projects root directory and type following `composer require zbynek/cs-api` command.

## Usage

```php
$csApi = new CSApi\AccountTransactionHistory($configFile);
```

> Initializes instance of CSApi object and starts authentication process with CS API server.
> A configuration file is required. You can find a sample for sandbox API in config/ folder.

```php
$account = 'CZ5508000000000379554193';
$parameters = [
    'dateStart' => '2014-05-01',
    'dateEnd' => '2014-05-30',
];

$response = $csApi->getTransactionHistory($account, $parameters);
```

> Requests account transaction history and returns data object (API response run through json_decode)

