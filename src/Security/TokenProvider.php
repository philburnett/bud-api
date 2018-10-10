<?php declare(strict_types=1);

namespace BudApi\Security;

use BudApi\Client\TokenClient;
use Exception;

class TokenProvider
{
    /**
     * @var TokenClient
     */
    private $client;

    /**
     * @var TokenStorageInterface
     */
    private $storage;

    private $clientId;

    private $clientSecret;

    /**
     * TokenProvider constructor.
     *
     * @param TokenClient           $client
     * @param TokenStorageInterface $storage
     * @param                       $clientId
     * @param                       $clientSecret
     */
    public function __construct(
        TokenClient $client,
        TokenStorageInterface $storage,
        $clientId,
        $clientSecret
    ) {
        $this->client = $client;
        // Not implemented but could use session storage, DB, APC, Memcache etc.
        $this->storage      = $storage;
        $this->clientId     = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getAuthHeader(): string
    {
        if ($this->storage->hasToken()) {
            $token = $this->storage->get();
        } else {
            $token = $this->client->post($this->clientSecret, $this->clientId);
            $this->storage->store($token);
        }

        return 'Bearer ' . $token['access_token'];
    }
}
