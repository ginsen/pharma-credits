<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Command\CreatePoint;

use App\Application\Command\CreatePoint\CreatePointCommand;
use App\Application\Command\CreatePoint\CreatePointHandler;
use App\Domain\Common\WriteModel\WriteModelEventInterface;
use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Service\ClientFinderInterface;
use App\Domain\Service\PharmacyFinderInterface;
use Assert\AssertionFailedException;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreatePointHandlerTest extends TestCase
{
    /**
     * @test
     * @throws AssertionFailedException|\Exception
     */
    public function it_should_callable()
    {
        $clientFinder   = $this->getDoubleClientFinder();
        $pharmacyFinder = $this->getDoublePharmacyFinder();
        $writeModel     = $this->getDoubleWriteModelEvent();

        $handler  = new CreatePointHandler($clientFinder, $pharmacyFinder, $writeModel);
        $handler($this->getCommand());

        self::assertInstanceOf(CreatePointHandler::class, $handler);
    }


    private function getDoubleClientFinder(): ClientFinderInterface
    {
        $clientFinder = m::mock(ClientFinderInterface::class);
        $clientFinder->shouldReceive('findOneOrFailByUuid')->andReturn($this->getDoubleClient());

        return $clientFinder;
    }


    private function getDoubleClient(): Client
    {
        $client = m::mock(Client::class);
        $client->shouldReceive('addPoint')->andReturnSelf();

        return $client;
    }


    /**
     * @return PharmacyFinderInterface
     */
    private function getDoublePharmacyFinder(): PharmacyFinderInterface
    {
        $pharmacyFinder = m::mock(PharmacyFinderInterface::class);
        $pharmacyFinder->shouldReceive('findOneOrFailByUuid')->andReturn($this->getDoublePharmacy());

        return $pharmacyFinder;
    }


    /**
     * @return Pharmacy
     */
    private function getDoublePharmacy(): Pharmacy
    {
        $pharmacy = m::mock(Pharmacy::class);
        $pharmacy->shouldReceive('addAwardedPoint')->andReturnSelf();

        return $pharmacy;
    }


    /**
     * @return WriteModelEventInterface
     */
    private function getDoubleWriteModelEvent(): WriteModelEventInterface
    {
        $writeModel = m::mock(WriteModelEventInterface::class);
        $writeModel->shouldReceive('queueToPersist');
        $writeModel->shouldReceive('persist');

        return $writeModel;
    }


    /**
     * @throws AssertionFailedException|\Exception
     * @return CreatePointCommand
     */
    private function getCommand(): CreatePointCommand
    {
        $clientUuid   = Uuid::uuid4();
        $pharmacyUuid = Uuid::uuid4();
        $quantity     = 3;

        $command = new CreatePointCommand($clientUuid->toString(), $pharmacyUuid->toString(), $quantity);

        return $command;
    }
}
