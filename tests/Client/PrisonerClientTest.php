<?php declare(strict_types=1);

namespace UnitTest\BudApi\Client;

use BudApi\Client\PrisonerClient;
use BudApi\Security\TokenProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Psr\Http\Message\StreamInterface;

class PrisonerClientTest extends MockeryTestCase
{
    /**
     * @var PrisonerClient
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

        $this->client = new PrisonerClient(
            $this->httpClient,
            $this->tokenProvider,
            ' https://death.star.api'
        );
    }

    public function testReturnsResponse()
    {
        $response = Mockery::mock(Response::class);
        $stream   = Mockery::mock(StreamInterface::class);

        $stream->shouldReceive('getContents')->andReturn('{"foo": "bar"}');
        $response->shouldReceive('getBody')->andReturn($stream);
        $this->tokenProvider->shouldReceive('getAuthHeader')->andReturn('Badgers');
        $this->httpClient->shouldReceive('get')
            ->with(
                ' https://death.star.api/prisoner/leia',
                [
                    'headers' => [
                        'Authorization' => 'Badgers',
                        'Content-Type'  => 'application/json',
                    ],
                ]
            )
            ->once()
            ->andReturn($response);

        $response = $this->client->get('leia');

        $this->assertArrayHasKey('foo', $response);
        $this->assertEquals($response['foo'], 'bar');
    }
}
