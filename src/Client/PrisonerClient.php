<?php declare(strict_types=1);

namespace BudApi\Client;

use Exception;

class PrisonerClient extends AbstractClient
{
    const PATH = '/prisoner';

    /**
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function get($id): array
    {
        $uri = $this->baseUrl . self::PATH . '/' . $id;

        try {
            $response = $this->client->get(
                $uri,
                [
                    'headers' => [
                        'Authorization' => $this->tokenProvider->getAuthHeader(),
                        'Content-Type'  => 'application/json',
                    ],
                ]
            );

            return json_decode($response->getBody()->getContents(), true);

        } catch (Exception $e) {
            // Handle non 2xx responses here
            throw $e;
        }
    }
}
