<?php

namespace HappyR\Google\ApiBundle\Factory;

use HappyR\Google\ApiBundle\Factory\Exception\BadGoogleServiceDefinitionException;
use HappyR\Google\ApiBundle\Services\AnalyticsService;
use HappyR\Google\ApiBundle\Services\DirectoryService;
use HappyR\Google\ApiBundle\Services\GoogleClient;
use HappyR\Google\ApiBundle\Services\GoogleServiceInterface;
use HappyR\Google\ApiBundle\Services\YoutubeService;

/**
 * Class GoogleServiceFactory
 */
class GoogleServiceFactory
{
    /**
     * Create staticly desired Service
     *
     * @param string $service Type of Service to create
     * @param GoogleClient $googleClient
     * @return GoogleServiceInterface Service instance
     * @throws BadGoogleServiceDefinitionException
     */
    static public function create($service, $googleClient)
    {
        $instance = null;

        switch ($service) {

            case 'analytics':
                $instance = new AnalyticsService($googleClient);
                break;

            case 'directory':
                $instance = new DirectoryService($googleClient);
                break;

            case 'youtube':
                $instance = new YoutubeService($googleClient);
                break;

            default:
                throw new BadGoogleServiceDefinitionException;
        }

        return $instance;
    }
}
