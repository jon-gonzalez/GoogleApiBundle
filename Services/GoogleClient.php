<?php

namespace HappyR\Google\ApiBundle\Services;

/**
 * Class GoogleClient
 *
 * This is the google client that is used by almost every api
 */
class GoogleClient
{
    /**
     * @var \Google_Client client
     */
    protected $client;
    protected $config;

    /**
     * @param \Google_Client $client
     * @param array $config
     */
    public function __construct(\Google_Client $client, array $config)
    {
        $this->config = $config;
        $this->client = $client;
    }

    public function setWebServerAuth()
    {
        $this->client->setApplicationName($this->config['application_name']);
        $this->client->setClientId($this->config['oauth2_client_id']);
        $this->client->setClientSecret($this->config['oauth2_client_secret']);
        $this->client->setRedirectUri($this->config['oauth2_redirect_uri']);
        $this->client->setDeveloperKey($this->config['developer_key']);
    }

    public function setServiceAuth()
    {
        $applicationName = $this->config['application_name'];
        $clientId = $this->config['oauth2_client_id'];
        $serviceAccountName = $this->config['service_account_name'];
        $scopes = $this->config['scopes']['directory'];
        $sub = (isset($this->config['sub'])) ? $this->config['sub'] : false;
        $keyFileLocation = $this->config['key_file_location'];
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
     * @return \Google_Client
     */
    public function getGoogleClient()
    {
        return $this->client;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this -> client -> setAccessToken($accessToken);
    }

    /**
     * @param string|null $code
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