<?php declare(strict_types=1);

namespace BudApi\Client;

use Exception;

class ExhaustClient extends AbstractClient
{
    const PATH = '/reator/exhaust';

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $uri = $this->baseUrl . self::PATH . '/' . $id;

        try {
            $this->client->delete(
                $uri,
                [
                    'headers' => [
                        'Authorization' => $this->tokenProvider->getAuthHeader(),
                        'Content-Type'  => 'application/json',
                        'x-torpedoes'   => 2,
                    ],
                ]
            );
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
