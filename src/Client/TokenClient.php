<?php declare(strict_types=1);

namespace BudApi\Client;

use Exception;

class TokenClient extends AbstractClient
{
    const PATH = '/token';

    /**
     * @param $id
     * @param $secret
     * @return array
     * @throws Exception
     */
    public function post($id, $secret): array
    {
        $uri           = $this->baseUrl . self::PATH;
        $base64        = base64_encode($id . ':' . $secret);
        $authorization = 'Basic ' . $base64;

        try {
            $response = $this->client->post(
                $uri,
                [
                    'headers'     => [
                        'Authorization' => $authorization,
                        'Content-Type'  => 'application/x-www-form-urlencoded',
                    ],
                    'form_params' => [
                        "grant_type" => "client_credentials",
                    ],
                ]
            );

            return json_decode($response->getBody()->getContents(), true);

        } catch (Exception $e) {
            // Handle errors here
            throw $e;
        }
    }
}
