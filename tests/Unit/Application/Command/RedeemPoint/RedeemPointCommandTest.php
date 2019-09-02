<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Command\RedeemPoint;

use App\Application\Command\RedeemPoint\RedeemPointCommand;
use App\Domain\ValueObj\QuantityPoints;
use App\Domain\ValueObj\RedeemedAt;
use Assert\AssertionFailedException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class RedeemPointCommandTest extends TestCase
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

        $command = new RedeemPointCommand($clientUuid->toString(), $pharmacyUuid->toString(), $quantity);

        self::assertInstanceOf(RedeemPointCommand::class, $command);
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

        $command = new RedeemPointCommand($clientUuid->toString(), $pharmacyUuid->toString(), $quantity);
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

        $command = new RedeemPointCommand($clientUuid->toString(), $pharmacyUuid->toString(), $quantity);
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

        $command = new RedeemPointCommand($clientUuid->toString(), $pharmacyUuid->toString(), $quantity);
        self::assertInstanceOf(QuantityPoints::class, $command->quantity);
    }


    /**
     * @test
     * @throws AssertionFailedException|\Exception
     */
    public function it_should_return_redeemed_at()
    {
        $clientUuid   = Uuid::uuid4();
        $pharmacyUuid = Uuid::uuid4();
        $quantity     = 3;

        $command = new RedeemPointCommand($clientUuid->toString(), $pharmacyUuid->toString(), $quantity);
        self::assertInstanceOf(RedeemedAt::class, $command->redeemedAt);
    }
}
