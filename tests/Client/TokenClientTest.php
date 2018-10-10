<?php declare(strict_types=1);

namespace UnitTest\BudApi\Client;

use BudApi\Client\ExhaustClient;
use BudApi\Client\TokenClient;
use BudApi\Security\TokenProvider;
use GuzzleHttp\Client;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;

class TokenClientTest extends MockeryTestCase
{
    /**
     * @var TokenClient
     */
    private $client;

    /**
     * @var MockInterface
     */
    private $httpClient;

    /**
     * @var MockInterface
     */
    private $tokenProvider;

    public function setUp()
    {
        $this->httpClient    = Mockery::mock(Client::class);
        $this->tokenProvider = Mockery::mock(TokenProvider::class);

        $this->client = new TokenClient(
            $this->httpClient,
            $this->tokenProvider,
            ' https://death.star.api'
        );
    }

    public function testFetchesToken()
    {
        $response = Mockery::mock(Response::class);
        $stream   = Mockery::mock(StreamInterface::class);

        $stream->shouldReceive('getContents')->andReturn('{"client_credentials": "foo"}');
        $response->shouldReceive('getBody')->andReturn($stream);

        $this->httpClient->shouldReceive('post')
            ->with(
                ' https://death.star.api/token',
                [
                    'headers'     => [
                        'Authorization' => 'Basic aWQ6c2VjcmV0',
                        'Content-Type'  => 'application/x-www-form-urlencoded',
                    ],
                    'form_params' => [
                        "grant_type" => "client_credentials",
                    ],
                ]
            )
            ->once()
            ->andReturn($response);

        $response = $this->client->post('id', 'secret');

        $this->assertArrayHasKey('client_credentials', $response);
        $this->assertEquals('foo', $response['client_credentials']);
    }
}
