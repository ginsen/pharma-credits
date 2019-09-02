<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Query\ClientBalance;

use App\Application\Query\ClientBalance\ClientBalanceHandler;
use App\Application\Query\ClientBalance\ClientBalanceQuery;
use App\Domain\Entity\Client;
use App\Domain\Service\ClientFinderInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ClientBalanceHandlerTest extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function it_should_callable()
    {
        $clientFinder = $this->getDoubleClientFinder();

        $handler  = new ClientBalanceHandler($clientFinder);
        $count    = $handler($this->getCommand());

        self::assertIsInt($count);
    }


    /**
     * @return ClientFinderInterface
     */
    private function getDoubleClientFinder(): ClientFinderInterface
    {
        $clientFinder = m::mock(ClientFinderInterface::class);
        $clientFinder->shouldReceive('findOneOrFailByUuid')->andReturn($this->getDoubleClient());

        return $clientFinder;
    }


    /**
     * @return Client
     */
    private function getDoubleClient(): Client
    {
        $client = m::mock(Client::class);
        $client->shouldReceive('getCountAvailablePoints')->andReturn(3);

        return $client;
    }


    /**
     * @throws \Exception
     * @return ClientBalanceQuery
     */
    private function getCommand(): ClientBalanceQuery
    {
        $clientUuid = Uuid::uuid4();

        return new ClientBalanceQuery($clientUuid->toString());
    }
}
