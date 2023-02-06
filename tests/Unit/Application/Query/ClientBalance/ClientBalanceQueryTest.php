<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Query\ClientBalance;

use App\Application\Query\ClientBalance\ClientBalanceQuery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ClientBalanceQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_create_one_instance()
    {
        $clientUuid = Uuid::uuid4();

        $command = new ClientBalanceQuery($clientUuid->toString());

        self::assertInstanceOf(ClientBalanceQuery::class, $command);
    }


    /**
     * @test
     */
    public function it_should_return_client_uuid()
    {
        $clientUuid = Uuid::uuid4();

        $command = new ClientBalanceQuery($clientUuid->toString());

        self::assertInstanceOf(ClientBalanceQuery::class, $command);
        self::assertInstanceOf(UuidInterface::class, $command->clientUuid());
    }
}
