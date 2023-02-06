<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Query\AwardPointClient;

use App\Application\Query\AwardPointClient\AwardPointClientQuery;
use App\Application\Query\AwardPointClient\AwardPointClientQueryHandler;
use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Service\Finder\ReadModel\ClientReadFinderInterface;
use App\Domain\Service\Finder\ReadModel\PharmacyReadFinderInterface;
use App\Domain\Service\Finder\ReadModel\PointReadFinderInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AwardPointClientQueryHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_callable()
    {
        $clientFinder     = $this->getDoubleClientFinder();
        $pharmacyFinder   = $this->getDoublePharmacyFinder();
        $pointCountFinder = $this->getDoublePointCountFinder();

        $handler  = new AwardPointClientQueryHandler($pharmacyFinder, $clientFinder, $pointCountFinder);
        $count    = $handler($this->getCommand());

        self::assertIsInt($count);
    }


    private function getDoubleClientFinder(): ClientReadFinderInterface
    {
        $clientFinder = m::mock(ClientReadFinderInterface::class);
        $clientFinder->shouldReceive('findOneOrFailByUuid')->andReturn($this->getDoubleClient());

        return $clientFinder;
    }


    private function getDoubleClient(): Client
    {
        return m::mock(Client::class);
    }


    private function getDoublePharmacyFinder(): PharmacyReadFinderInterface
    {
        $pharmacyFinder = m::mock(PharmacyReadFinderInterface::class);
        $pharmacyFinder->shouldReceive('findOneOrFailByUuid')->andReturn($this->getDoublePharmacy());

        return $pharmacyFinder;
    }


    private function getDoublePharmacy(): Pharmacy
    {
        return m::mock(Pharmacy::class);
    }


    private function getDoublePointCountFinder(): PointReadFinderInterface
    {
        $pointCountFinder = m::mock(PointReadFinderInterface::class);
        $pointCountFinder->shouldReceive('countAwardPointsClient')->andReturn(3);

        return $pointCountFinder;
    }


    private function getCommand(): AwardPointClientQuery
    {
        $clientUuid   = Uuid::uuid4();
        $pharmacyUuid = Uuid::uuid4();

        return new AwardPointClientQuery($clientUuid->toString(), $pharmacyUuid->toString());
    }
}
