<?php

namespace HappyR\Google\ApiBundle\Services;

/**
 * Class DirectoryService
 *
 * This is the class that communicates with directory api
 */
class DirectoryService extends \Google_Service_Directory implements GoogleServiceInterface
{
    /**
     * @var GoogleClient client
     *
     *
     */
    public $client;

    /**
     * Constructor
     * @param GoogleClient $client
     */
    public function __construct(GoogleClient $client)
    {
        $this->client=$client;
        parent::__construct($client->getGoogleClient());
    }
}
