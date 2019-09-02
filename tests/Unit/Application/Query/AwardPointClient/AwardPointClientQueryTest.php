<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Query\AwardPointClient;

use App\Application\Query\AwardPointClient\AwardPointClientQuery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class AwardPointClientQueryTest extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function it_should_create_one_instance()
    {
        $clientUuid   = Uuid::uuid4();
        $pharmacyUuid = Uuid::uuid4();

        $command = new AwardPointClientQuery($clientUuid->toString(), $pharmacyUuid->toString());

        self::assertInstanceOf(AwardPointClientQuery::class, $command);
    }


    /**
     * @test
     * @throws \Exception
     */
    public function it_should_return_client_uuid()
    {
        $clientUuid   = Uuid::uuid4();
        $pharmacyUuid = Uuid::uuid4();

        $command = new AwardPointClientQuery($clientUuid->toString(), $pharmacyUuid->toString());
        self::assertInstanceOf(UuidInterface::class, $command->clientUuid);
    }


    /**
     * @test
     * @throws \Exception
     */
    public function it_should_return_pharmacy_uuid()
    {
        $clientUuid   = Uuid::uuid4();
        $pharmacyUuid = Uuid::uuid4();

        $command = new AwardPointClientQuery($clientUuid->toString(), $pharmacyUuid->toString());
        self::assertInstanceOf(UuidInterface::class, $command->pharmacyUuid);
    }
}
