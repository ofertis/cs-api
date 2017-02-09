<?php namespace CSApi;

use League\OAuth2\Client\Token\AccessToken;

abstract class CSApi
{
    /**
     * Configuration settings
     *
     * @var array
     */
    protected $config;

    /**
     * Access token for authentication
     *
     * @var AccessToken
     */
    protected $accessToken;

    /**
     * Initializes CSApi and starts authentication process
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->init();
    }

    /**
     * Initialize function - get access token object from provider
     *
     * @return void
     */
    protected function init()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->accessToken = OAuthAuthorization::callAccessTokenProvider($this->config);
    }

    /**
     * Requests data from API
     *
     * @param string $account
     * @param array $parametersArray
     *
     * @return object
     */
    protected abstract function getApiData($account, array $parametersArray = []);
}