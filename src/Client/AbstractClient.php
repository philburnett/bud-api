<?php declare(strict_types=1);

namespace BudApi\Client;

use BudApi\Security\TokenProvider;
use GuzzleHttp\Client;

class AbstractClient
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string|string
     */
    protected $baseUrl;

    /**
     * @var TokenProvider
     */
    protected $tokenProvider;

    /**
     * AbstractClient constructor.
     *
     * @param Client        $client
     * @param TokenProvider $tokenProvider
     * @param string        $baseUrl
     */
    public function __construct(
        Client $client,
        TokenProvider $tokenProvider,
        string $baseUrl
    ) {
        $this->client        = $client;
        $this->tokenProvider = $tokenProvider;
        $this->baseUrl       = $baseUrl;
    }
}
