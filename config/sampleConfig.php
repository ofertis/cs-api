<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Client ID & password & API key assigned to you by the provider (required)
    |--------------------------------------------------------------------------
    */

    'clientId'                => 'WebExpoClient',
    'clientSecret'            => '201509201300',
    'webApiKey'               => '8c18ff92-8c1c-44b6-8b0c-08e19d206fcf',

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
    | URL required to access specific parts of API
    |
    | Note the bracketed {account} and {parameters}, these will be substituted
    | during API calls for variables supplied by you
    |--------------------------------------------------------------------------
    */

    'urlTransactions'         => 'https://api.csas.cz/sandbox/webapi/api/v1/netbanking/my/accounts/{account}/transactions?{parameters}',

];