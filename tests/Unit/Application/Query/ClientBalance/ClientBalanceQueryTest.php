<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Query\ClientBalance;

use App\Application\Query\ClientBalance\ClientBalanceQuery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ClientBalanceQueryTest extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function it_should_create_one_instance()
    {
        $clientUuid = Uuid::uuid4();

        $command = new ClientBalanceQuery($clientUuid->toString());

        self::assertInstanceOf(ClientBalanceQuery::class, $command);
    }


    /**
     * @test
     * @throws \Exception
     */
    public function it_should_return_client_uuid()
    {
        $clientUuid = Uuid::uuid4();

        $command = new ClientBalanceQuery($clientUuid->toString());

        self::assertInstanceOf(ClientBalanceQuery::class, $command);
        self::assertInstanceOf(UuidInterface::class, $command->clientUuid);
    }
}
