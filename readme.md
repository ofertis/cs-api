# CS-API

Library for accessing Ceska sporitelna API
 
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
$configFile = include('./config/sampleConfig.php');
$csApi = new CSApi\ApiRequester($configFile);
```

> Initializes instance of CSApi object and starts authentication process with CS API server.
> A configuration file is required. You can find a sample for sandbox API in config/ folder.

```php
$apiUrl = 'urlTransactionHistory';
$urlParameters = [
    'account' => 'CZ5508000000000379554193',
    'query' => [
        'dateStart' => '2014-05-01',
        'dateEnd' => '2014-05-30',
    ]
];
$response = $csApi->apiRequest($apiUrl, $urlParameters);
```

> Requests account transaction history and returns data object (API response run through json_decode),
> Content of 'query' key will be transformed into http query.

```php
$apiUrl = 'urlTransactions';
$urlParameters = [
    'id' => 'D2C8C1DCC51A3738538A40A4863CA288E0225E52',
    'tid' => '100000189114334',
];
$postData = [
    'note' => 'New client\'s personal note for transaction',
    'flags' => [
        'hasStar'
    ]
];
$response = $csApi->apiRequest($apiUrl, $urlParameters, $postData);
```

> Adds/changes a client's personal note and returns a response.


