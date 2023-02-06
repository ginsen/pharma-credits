<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Command\RedeemPoint;

use App\Application\Command\RedeemPoint\RedeemPointCommand;
use App\Application\Command\RedeemPoint\RedeemPointCommandHandler;
use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Entity\Point;
use App\Domain\Service\Finder\WriteModel\ClientWriteFinderInterface;
use App\Domain\Service\Finder\WriteModel\PharmacyWriteFinderInterface;
use App\Domain\ValueObj\AwardedAt;
use App\Domain\ValueObj\ClientName;
use App\Domain\ValueObj\PharmacyName;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class RedeemPointCommandHandlerTest extends TestCase
{
    private Client $client;
    private Pharmacy $pharmacy;


    protected function setUp(): void
    {
        $this->client   = $this->getClient();
        $this->pharmacy = $this->getPharmacy();
        $this->addPoints(2);
    }


    /**
     * @test
     */
    public function it_should_callable()
    {
        $clientFinder   = $this->getDoubleClientFinder();
        $pharmacyFinder = $this->getDoublePharmacyFinder();

        $handler  = new RedeemPointCommandHandler($clientFinder, $pharmacyFinder);
        $handler($this->getCommand());

        self::assertInstanceOf(RedeemPointCommandHandler::class, $handler);
    }


    private function getDoubleClientFinder(): ClientWriteFinderInterface
    {
        $clientFinder = m::mock(ClientWriteFinderInterface::class);
        $clientFinder
            ->shouldReceive('findOneOrFailByUuid')
            ->andReturn($this->client);

        return $clientFinder;
    }


    private function getDoublePharmacyFinder(): PharmacyWriteFinderInterface
    {
        $pharmacyFinder = m::mock(PharmacyWriteFinderInterface::class);
        $pharmacyFinder
            ->shouldReceive('findOneOrFailByUuid')
            ->andReturn($this->pharmacy);

        return $pharmacyFinder;
    }


    private function getCommand(): RedeemPointCommand
    {
        $clientUuid   = $this->client->uuid();
        $pharmacyUuid = $this->pharmacy->uuid();
        $quantity     = 2;

        return new RedeemPointCommand($clientUuid->toString(), $pharmacyUuid->toString(), $quantity);
    }


    private function getClient(): Client
    {
        $uuid = Uuid::uuid4();
        $name = ClientName::fromStr('client');

        return Client::create($uuid, $name);
    }


    private function getPharmacy(): Pharmacy
    {
        $uuid = Uuid::uuid4();
        $name = PharmacyName::fromStr('pharmacy');

        return Pharmacy::create($uuid, $name);
    }


    private function addPoints(int $num): void
    {
        $time = AwardedAt::now();

        while ($num > 0) {
            Point::createAwardPoint($this->client, $this->pharmacy, $time);
            --$num;
        }
    }
}
