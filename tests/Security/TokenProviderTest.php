<?php declare(strict_types=1);

namespace UnitTest\BudApi\Security;

use BudApi\Client\TokenClient;
use BudApi\Security\TokenProvider;
use BudApi\Security\TokenStorageInterface;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Mockery\MockInterfacee;

class TokenProviderTest extends MockeryTestCase
{
    /**
     * @var MockInterface
     */
    private $client;

    /**
     * @var MockInterface
     */
    private $storage;

    /**
     * @var TokenProvider
     */
    private $provider;

    public function setUp()
    {
        $this->client   = Mockery::mock(TokenClient::class);
        $this->storage  = Mockery::mock(TokenStorageInterface::class);
        $this->provider = new TokenProvider(
            $this->client,
            $this->storage,
            'id',
            'secret'
        );
    }

    public function testGetAuthHeaderFetchesFromApi()
    {
        $this->storage->shouldReceive('hasToken')->once()->andReturn(false);
        $this->storage->shouldReceive('store')->once();
        $this->client->shouldReceive('post')->once()->andReturn([
            'access_token' => 'Badgers'
        ]);
        $header = $this->provider->getAuthHeader();

        $this->assertEquals('Bearer Badgers', $header);
    }

    public function testGetAuthHeaderFromStorage()
    {
        $this->storage->shouldReceive('hasToken')->once()->andReturn(true);
        $this->storage->shouldReceive('get')->once()->andReturn([
            'access_token' => 'Badgers'
        ]);
        $header = $this->provider->getAuthHeader();

        $this->assertEquals('Bearer Badgers', $header);
        $this->assertEquals('Bearer Badgers', $header);
    }
}
