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
use App\Domain\ValueObj\AwardedAt;
use App\Domain\ValueObj\ClientName;
use App\Domain\ValueObj\PharmacyName;
use Assert\AssertionFailedException;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class RedeemPointHandlerTest extends TestCase
{
    /** @var Client */
    private $client;

    /** @var Pharmacy */
    private $pharmacy;


    /**
     * {@inheritdoc}
     * @throws AssertionFailedException
     */
    protected function setUp()
    {
        $this->client   = $this->getClient();
        $this->pharmacy = $this->getPharmacy();
        $this->addPoints(2);
    }


    /**
     * @test
     * @throws AssertionFailedException|\Exception
     */
    public function it_should_callable()
    {
        $clientFinder   = $this->getDoubleClientFinder();
        $pharmacyFinder = $this->getDoublePharmacyFinder();
        $writeModel     = $this->getDoubleWriteModelEvent();

        $handler  = new RedeemPointHandler($clientFinder, $pharmacyFinder, $writeModel);
        $handler($this->getCommand());

        self::assertInstanceOf(RedeemPointHandler::class, $handler);
    }


    /**
     * @throws \Exception|AssertionFailedException
     * @return ClientFinderInterface
     */
    private function getDoubleClientFinder(): ClientFinderInterface
    {
        $clientFinder = m::mock(ClientFinderInterface::class);
        $clientFinder->shouldReceive('findOneOrFailByUuid')->andReturn($this->client);

        return $clientFinder;
    }


    /**
     * @throws \Exception|AssertionFailedException
     * @return PharmacyFinderInterface
     */
    private function getDoublePharmacyFinder(): PharmacyFinderInterface
    {
        $pharmacyFinder = m::mock(PharmacyFinderInterface::class);
        $pharmacyFinder->shouldReceive('findOneOrFailByUuid')->andReturn($this->pharmacy);

        return $pharmacyFinder;
    }


    /**
     * @return WriteModelInterface
     */
    private function getDoubleWriteModelEvent(): WriteModelInterface
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
        $clientUuid   = $this->client->getUuid();
        $pharmacyUuid = $this->pharmacy->getUuid();
        $quantity     = 2;

        $command = new RedeemPointCommand($clientUuid->toString(), $pharmacyUuid->toString(), $quantity);

        return $command;
    }


    /**
     * @throws \Exception|AssertionFailedException
     * @return Client
     */
    private function getClient(): Client
    {
        $uuid = Uuid::uuid4();
        $name = ClientName::fromStr('client');

        $client = Client::create($uuid, $name);

        return $client;
    }


    /**
     * @throws \Exception|AssertionFailedException
     * @return Pharmacy
     */
    private function getPharmacy(): Pharmacy
    {
        $uuid = Uuid::uuid4();
        $name = PharmacyName::fromStr('pharmacy');

        return Pharmacy::create($uuid, $name);
    }


    /**
     * @param int $num
     * @throws \Exception|AssertionFailedException
     */
    private function addPoints(int $num)
    {
        $time = AwardedAt::now();

        while ($num > 0) {
            Point::createAwardPoint($this->client, $this->pharmacy, $time);
            --$num;
        }
    }
}
