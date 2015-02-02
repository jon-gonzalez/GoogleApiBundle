<?php

namespace HappyR\Google\ApiBundle\Factory;

use HappyR\Google\ApiBundle\Factory\Exception\BadGoogleClientDefinitionException;
use HappyR\Google\ApiBundle\Services\GoogleClient;

/**
 * Class GoogleClientFactory
 */
class GoogleClientFactory
{
    /**
     * Create staticly desired Google Client
     *
     * @param array $config
     * @param string $type
     * @return GoogleClient instance
     * @throws BadGoogleClientDefinitionException
     */
    static public function create($config, $type = "default")
    {
        $instance = null;
        $authConfig = (isset($config["auth"]["auth_clients"][$type]))
            ? $config["auth"]["auth_clients"][$type]
            : current($config["auth"]["auth_clients"])
        ;
        $client = new \Google_Client();

        $instance = new GoogleClient($client, $authConfig[$config['auth_type']]);

        switch ($config['auth_type']) {

            case 'web_server_auth':
                $instance->setWebServerAuth();
                break;

            case 'service_account_auth':
                $instance->setServiceAuth();
                break;

            default:
                throw new BadGoogleClientDefinitionException;
        }

        return $instance;
    }
}
