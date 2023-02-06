<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Command\CreatePoint;

use App\Application\Command\CreatePoint\CreatePointCommand;
use App\Application\Command\CreatePoint\CreatePointCommandHandler;
use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Service\Finder\WriteModel\ClientWriteFinderInterface;
use App\Domain\Service\Finder\WriteModel\PharmacyWriteFinderInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreatePointCommandHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_callable()
    {
        $clientFinder   = $this->getDoubleClientFinder();
        $pharmacyFinder = $this->getDoublePharmacyFinder();

        $handler  = new CreatePointCommandHandler($clientFinder, $pharmacyFinder);
        $handler($this->getCommand());

        self::assertInstanceOf(CreatePointCommandHandler::class, $handler);
    }


    private function getDoubleClientFinder(): ClientWriteFinderInterface
    {
        $clientFinder = m::mock(ClientWriteFinderInterface::class);
        $clientFinder->shouldReceive('findOneOrFailByUuid')->andReturn($this->getDoubleClient());

        return $clientFinder;
    }


    private function getDoubleClient(): Client
    {
        $client = m::mock(Client::class);
        $client
            ->shouldReceive('addPoint')
            ->andReturnSelf();

        return $client;
    }



    private function getDoublePharmacyFinder(): PharmacyWriteFinderInterface
    {
        $pharmacyFinder = m::mock(PharmacyWriteFinderInterface::class);
        $pharmacyFinder
            ->shouldReceive('findOneOrFailByUuid')
            ->andReturn($this->getDoublePharmacy());

        return $pharmacyFinder;
    }


    private function getDoublePharmacy(): Pharmacy
    {
        $pharmacy = m::mock(Pharmacy::class);
        $pharmacy
            ->shouldReceive('addAwardedPoint')
            ->andReturnSelf();

        return $pharmacy;
    }


    /**
     * @throws
     */
    private function getCommand(): CreatePointCommand
    {
        $clientUuid   = Uuid::uuid4();
        $pharmacyUuid = Uuid::uuid4();
        $quantity     = 3;

        return new CreatePointCommand($clientUuid->toString(), $pharmacyUuid->toString(), $quantity);
    }
}
