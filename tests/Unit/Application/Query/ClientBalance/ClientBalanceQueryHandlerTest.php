<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Query\ClientBalance;

use App\Application\Query\ClientBalance\ClientBalanceQuery;
use App\Application\Query\ClientBalance\ClientBalanceQueryHandler;
use App\Domain\Entity\Client;
use App\Domain\Service\Finder\ReadModel\ClientReadFinderInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ClientBalanceQueryHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_callable()
    {
        $clientFinder = $this->getDoubleClientFinder();

        $handler  = new ClientBalanceQueryHandler($clientFinder);
        $count    = $handler($this->getCommand());

        self::assertIsInt($count);
    }


    private function getDoubleClientFinder(): ClientReadFinderInterface
    {
        $clientFinder = m::mock(ClientReadFinderInterface::class);
        $clientFinder
            ->shouldReceive('findOneOrFailByUuid')
            ->andReturn($this->getDoubleClient());

        return $clientFinder;
    }


    private function getDoubleClient(): Client
    {
        $client = m::mock(Client::class);
        $client
            ->shouldReceive('getCountAvailablePoints')
            ->andReturn(3);

        return $client;
    }


    private function getCommand(): ClientBalanceQuery
    {
        $clientUuid = Uuid::uuid4();

        return new ClientBalanceQuery($clientUuid->toString());
    }
}
