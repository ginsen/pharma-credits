<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Query\AwardPointClient;

use App\Application\Query\AwardPointClient\AwardPointClientHandler;
use App\Application\Query\AwardPointClient\AwardPointClientQuery;
use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Service\ClientFinderInterface;
use App\Domain\Service\PharmacyFinderInterface;
use App\Domain\Service\PointCountFinderInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AwardPointClientHandlerTest extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function it_should_callable()
    {
        $clientFinder     = $this->getDoubleClientFinder();
        $pharmacyFinder   = $this->getDoublePharmacyFinder();
        $pointCountFinder = $this->getDoublePointCountFinder();

        $handler  = new AwardPointClientHandler($pharmacyFinder, $clientFinder, $pointCountFinder);
        $count    = $handler($this->getCommand());

        self::assertIsInt($count);
    }


    /**
     * @return ClientFinderInterface
     */
    private function getDoubleClientFinder(): ClientFinderInterface
    {
        $clientFinder = m::mock(ClientFinderInterface::class);
        $clientFinder->shouldReceive('findOneOrFailByUuid')->andReturn($this->getDoubleClient());

        return $clientFinder;
    }


    /**
     * @return Client
     */
    private function getDoubleClient(): Client
    {
        $client = m::mock(Client::class);

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

        return $pharmacy;
    }


    /**
     * @return PointCountFinderInterface
     */
    private function getDoublePointCountFinder(): PointCountFinderInterface
    {
        $pointCountFinder = m::mock(PointCountFinderInterface::class);
        $pointCountFinder->shouldReceive('countAwardPointsClient')->andReturn(3);

        return $pointCountFinder;
    }


    /**
     * @throws \Exception
     * @return AwardPointClientQuery
     */
    private function getCommand(): AwardPointClientQuery
    {
        $clientUuid   = Uuid::uuid4();
        $pharmacyUuid = Uuid::uuid4();

        $command = new AwardPointClientQuery($clientUuid->toString(), $pharmacyUuid->toString());

        return $command;
    }
}
