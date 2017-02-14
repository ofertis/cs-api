<?php namespace CSApi;

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessToken;

class OAuthAuthorization
{
    /**
     * Calls access token provider and returns AccessToken
     *
     * @param array $config
     *
     * @return AccessToken
     */
    public static function callAccessTokenProvider(array $config)
    {
        $provider = new GenericProvider([
            'clientId'                => $config['clientId'],
            'clientSecret'            => $config['clientSecret'],
            'redirectUri'             => $config['redirectUri'],
            'urlAuthorize'            => $config['urlAuthorize'],
            'urlAccessToken'          => $config['urlAccessToken'],
            'urlResourceOwnerDetails' => $config['urlResourceOwnerDetails'],
        ]);

        if(isset($_SESSION['accessToken']))
        {
            $accessToken = unserialize($_SESSION['accessToken']);

            // Check if the access token has expired
            if($accessToken->hasExpired())
            {
                // Check if the refresh token is null
                if($accessToken->getRefreshToken())
                {
                    $accessToken = self::refreshAccessToken($provider, $accessToken);
                }
                else
                {
                    $accessToken = self::requestNewAccessToken($provider);
                }

                $_SESSION['accessToken'] = serialize($accessToken);
            }
        }
        else
        {
            $accessToken = self::requestNewAccessToken($provider);
        }

        $_SESSION['accessToken'] = serialize($accessToken);
        return $accessToken;
    }

    /**
     * Calls access token provider and returns new AccessToken
     *
     * @param GenericProvider $provider
     *
     * @return AccessToken
     */

    public static function requestNewAccessToken(GenericProvider $provider)
    {
        // If we don't have an authorization code then get one
        if (!isset($_GET['code'])) {

            // Fetch the authorization URL from the provider; this returns the
            // urlAuthorize option and generates and applies any necessary parameters
            // (e.g. state).
            $options = [
                'state'                   => 'profil',
                'response_type'           => 'code',
                'access_type'             => 'offline',
                'approval_prompt'         => 'force'
            ];
            $authorizationUrl = $provider->getAuthorizationUrl($options);

            // Get the state generated for you and store it to the session.
            $_SESSION['oauth2state'] = $provider->getState();

            // Redirect the user to the authorization URL.
            header('Location: ' . $authorizationUrl);
            exit;


        }
        // Check given state against previously stored one to mitigate CSRF attack
        /*
        elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

            unset($_SESSION['oauth2state']);
            exit('Invalid state');

        }*/
        else {

            try {

                // Try to get an access token using the authorization code grant.
                $accessToken = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
                return $accessToken;

            } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

                // Failed to get the access token or user details.
                exit($e->getMessage());

            }

        }
    }

    /**
     * Calls access token provider and returns refreshed AccessToken
     *
     * @param GenericProvider $provider
     * @param AccessToken $accessToken
     *
     * @return AccessToken
     */

    public static function refreshAccessToken(GenericProvider $provider, AccessToken $accessToken)
    {
        $newAccessToken = $provider->getAccessToken('refresh_token', [
            'refresh_token' => $accessToken->getRefreshToken(),
        ]);
        $refObject   = new \ReflectionObject( $newAccessToken );
        $refProperty = $refObject->getProperty( 'refreshToken' );
        $refProperty->setAccessible( true );
        $refProperty->setValue($newAccessToken, $accessToken->getRefreshToken());

        return $newAccessToken;
    }
}