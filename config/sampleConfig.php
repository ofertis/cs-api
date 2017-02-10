<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Client ID & password & API key assigned to you by the provider (required)
    |--------------------------------------------------------------------------
    */

    'clientId'                => 'WebExpoClient',
    'clientSecret'            => '201509201300',
    'webApiKey'               => '35bd5a35-5909-460e-b3c2-20073d9c4c2e',

    /*
    |--------------------------------------------------------------------------
    | Your redirect URL required to access CS Api
    |--------------------------------------------------------------------------
    */

    'redirectUri'             => 'http://localhost/redirect',

    /*
    |--------------------------------------------------------------------------
    | URL required to authenticate a user
    |--------------------------------------------------------------------------
    */

    'urlAuthorize'            => 'https://api.csas.cz/sandbox/widp/oauth2/auth',
    'urlAccessToken'          => 'https://api.csas.cz/sandbox/widp/oauth2/token',
    'urlResourceOwnerDetails' => 'https://api.csas.cz/sandbox/widp/oauth2/transactions',

    /*
    |--------------------------------------------------------------------------
    | URLs required to access specific parts of API
    |
    | Add as many API request URLs from CS API documentation as you need.
    | Use '%s' to mark parameters you want to assign dynamically.
    |--------------------------------------------------------------------------
    */

    'urlTransactionHistory' => 'https://api.csas.cz/sandbox/webapi/api/v1/netbanking/my/accounts/%s/transactions?%s',
    'urlTransactions'       => 'https://api.csas.cz/sandbox/webapi/api/v3/netbanking/my/accounts/%s/transactions/%s',

];