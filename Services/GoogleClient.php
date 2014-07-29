<?php

namespace HappyR\Google\ApiBundle\Services;

use GoogleApi\Client;

/**
 * Class GoogleClient
 *
 * This is the google client that is used by almost every api
 */
class GoogleClient
{
    /**
     * @var \GoogleApi\Client client
     *
     *
     */
    protected $client;
    protected $config;

    /**
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        // True if objects should be returned by the service classes.
        // False if associative arrays should be returned (default behavior).
        $this->config = $config;
        $this->config['use_objects'] = true;
        $this->client = new \Google_Client($this->config);

        switch ($this->config['auth_type']) {
            case 'web_server_auth':
                $this->setWebServerAuth();
                break;
            
            case 'service_account_auth':
                $this->setServiceAuth();
                break;
        }
    }

    private function setWebServerAuth()
    {
        $this->client->setApplicationName($this->config['web_server_auth']['application_name']);
        $this->client->setClientId($this->config['web_server_auth']['oauth2_client_id']);
        $this->client->setClientSecret($this->config['web_server_auth']['oauth2_client_secret']);
        $this->client->setRedirectUri($this->config['web_server_auth']['oauth2_redirect_uri']);
        $this->client->setDeveloperKey($this->config['web_server_auth']['developer_key']);
    }

    private function setServiceAuth()
    {
        $applicationName = $this->config['service_account_auth']['application_name'];
        $clientId = $this->config['service_account_auth']['oauth2_client_id'];
        $serviceAccountName = $this->config['service_account_auth']['service_account_name'];
        $scopes = $this->config['service_account_auth']['scopes']['directory'];
        $sub = (isset($this->config['service_account_auth']['sub'])) ? $this->config['service_account_auth']['sub'] : false;
        $keyFileLocation = $this->config['service_account_auth']['key_file_location'];
        $key = file_get_contents($keyFileLocation);

        $cred = new \Google_Auth_AssertionCredentials(
            $serviceAccountName,
            $scopes,
            $key,
            'notasecret',
            'http://oauth.net/grant_type/jwt/1.0/bearer',
            $sub
        );

        $this->client->setApplicationName($applicationName);
        $this->client->setClientId($clientId);
        $this->client->setAssertionCredentials($cred);
    }

    /**
     *
     * @return Client
     */
    public function getGoogleClient()
    {
        return $this->client;
    }

    /**
     *
     * @param string $accessToken
     *
     */
    public function setAccessToken($accessToken)
    {
        $this -> client -> setAccessToken($accessToken);
    }

    /**
     *
     * @param string|null $code
     *
     */
    public function authenticate($code = null)
    {
        $this->client->authenticate($code);
    }

    /**
     * Construct the OAuth 2.0 authorization request URI.
     * @return string
     */
    public function createAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    /**
     * Get the OAuth 2.0 access token.
     * @return string $accessToken JSON encoded string in the following format:
     * {"access_token":"TOKEN", "refresh_token":"TOKEN", "token_type":"Bearer",
     *  "expires_in":3600,"id_token":"TOKEN", "created":1320790426}
     */
    public function getAccessToken()
    {
        return $this->client->getAccessToken();
    }

    /**
     * Returns if the access_token is expired.
     * @return bool Returns True if the access_token is expired.
     */
    public function isAccessTokenExpired()
    {
        return $this->client->isAccessTokenExpired();
    }
}