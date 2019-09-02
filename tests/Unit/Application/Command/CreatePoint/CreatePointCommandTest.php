<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Command\CreatePoint;

use App\Application\Command\CreatePoint\CreatePointCommand;
use App\Domain\ValueObj\AwardedAt;
use App\Domain\ValueObj\QuantityPoints;
use Assert\AssertionFailedException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class CreatePointCommandTest extends TestCase
{
    /**
     * @test
     * @throws AssertionFailedException|\Exception
     */
    public function it_should_create_one_instance()
    {
        $clientUuid   = Uuid::uuid4();
        $pharmacyUuid = Uuid::uuid4();
        $quantity     = 3;

        $command = new CreatePointCommand($clientUuid->toString(), $pharmacyUuid->toString(), $quantity);

        self::assertInstanceOf(CreatePointCommand::class, $command);
    }


    /**
     * @test
     * @throws AssertionFailedException|\Exception
     */
    public function it_should_return_client_uuid()
    {
        $clientUuid   = Uuid::uuid4();
        $pharmacyUuid = Uuid::uuid4();
        $quantity     = 3;

        $command = new CreatePointCommand($clientUuid->toString(), $pharmacyUuid->toString(), $quantity);
        self::assertInstanceOf(UuidInterface::class, $command->clientUuid);
    }


    /**
     * @test
     * @throws AssertionFailedException|\Exception
     */
    public function it_should_return_pharmacy_uuid()
    {
        $clientUuid   = Uuid::uuid4();
        $pharmacyUuid = Uuid::uuid4();
        $quantity     = 3;

        $command = new CreatePointCommand($clientUuid->toString(), $pharmacyUuid->toString(), $quantity);
        self::assertInstanceOf(UuidInterface::class, $command->pharmacyUuid);
    }


    /**
     * @test
     * @throws AssertionFailedException|\Exception
     */
    public function it_should_return_quantity()
    {
        $clientUuid   = Uuid::uuid4();
        $pharmacyUuid = Uuid::uuid4();
        $quantity     = 3;

        $command = new CreatePointCommand($clientUuid->toString(), $pharmacyUuid->toString(), $quantity);
        self::assertInstanceOf(QuantityPoints::class, $command->quantity);
    }


    /**
     * @test
     * @throws AssertionFailedException|\Exception
     */
    public function it_should_return_awarded_at()
    {
        $clientUuid   = Uuid::uuid4();
        $pharmacyUuid = Uuid::uuid4();
        $quantity     = 3;

        $command = new CreatePointCommand($clientUuid->toString(), $pharmacyUuid->toString(), $quantity);
        self::assertInstanceOf(AwardedAt::class, $command->awardedAt);
    }
}
