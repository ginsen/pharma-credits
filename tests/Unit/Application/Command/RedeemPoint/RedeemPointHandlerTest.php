<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Command\RedeemPoint;

use App\Application\Command\RedeemPoint\RedeemPointCommand;
use App\Application\Command\RedeemPoint\RedeemPointHandler;
use App\Domain\Common\WriteModel\WriteModelInterface;
use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Entity\Point;
use App\Domain\Service\ClientFinderInterface;
use App\Domain\Service\PharmacyFinderInterface;
use Assert\AssertionFailedException;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class RedeemPointHandlerTest extends TestCase
{
    /**
     * @test
     * @throws AssertionFailedException|\Exception
     */
    public function it_should_callable()
    {
        $clientFinder   = $this->getDoubleClientFinder();
        $pharmacyFinder = $this->getDoublePharmacyFinder();
        $writeModel     = $this->getDoubleWriteModel();

        $handler  = new RedeemPointHandler($clientFinder, $pharmacyFinder, $writeModel);
        $handler($this->getCommand());

        self::assertInstanceOf(RedeemPointHandler::class, $handler);
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
        $client->shouldReceive('getPoints')->andReturn($this->getArrayPoints());

        return $client;
    }


    /**
     * @return Point[]
     */
    private function getArrayPoints(): array
    {
        return [
            $this->getDoublePoint(),
            $this->getDoublePoint(),
        ];
    }


    /**
     * @return Point
     */
    private function getDoublePoint(): Point
    {
        $point = m::mock(Point::class);
        $point->shouldReceive('redeem')->andReturnSelf();

        return $point;
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

        return $pharmacy;
    }


    /**
     * @return WriteModelInterface
     */
    private function getDoubleWriteModel(): WriteModelInterface
    {
        $writeModel = m::mock(WriteModelInterface::class);
        $writeModel->shouldReceive('queueToPersist');
        $writeModel->shouldReceive('persist');

        return $writeModel;
    }


    /**
     * @throws AssertionFailedException|\Exception
     * @return RedeemPointCommand
     */
    private function getCommand(): RedeemPointCommand
    {
        $clientUuid   = Uuid::uuid4();
        $pharmacyUuid = Uuid::uuid4();
        $quantity     = 2;

        $command = new RedeemPointCommand($clientUuid->toString(), $pharmacyUuid->toString(), $quantity);

        return $command;
    }
}
