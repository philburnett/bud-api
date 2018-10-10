<?php declare(strict_types=1);

namespace UnitTest\BudApi\Client;

use BudApi\Client\ExhaustClient;
use BudApi\Security\TokenProvider;
use GuzzleHttp\Client;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;

class ExhaustClientTest extends MockeryTestCase
{

    /**
     * @var ExhaustClient
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

        $this->client = new ExhaustClient(
            $this->httpClient,
            $this->tokenProvider,
            ' https://death.star.api'
        );
    }

    public function testDeleteReturnsTrue()
    {
        $this->tokenProvider->shouldReceive('getAuthHeader')->andReturn('Badgers');
        $this->httpClient->shouldReceive('delete')
            ->with(
                ' https://death.star.api/reator/exhaust/1',
                [
                    'headers' => [
                        'Authorization' => 'Badgers',
                        'Content-Type'  => 'application/json',
                        'x-torpedoes'   => 2,
                    ],
                ]
            )
            ->once()
            ->andReturn('foo');

        $response = $this->client->delete(1);
        $this->assertTrue($response);
    }

    public function testReturnsFalse()
    {
        $this->tokenProvider->shouldReceive('getAuthHeader')->andReturn('Badgers');
        $this->httpClient->shouldReceive('delete')
            ->once()
            ->andThrow(new \Exception());

        $response = $this->client->delete(1);
        $this->assertfalse($response);
    }
}
