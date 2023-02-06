<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Query\AwardPointDates;

use App\Application\Query\AwardPointDates\AwardPointDatesQuery;
use App\Application\Query\AwardPointDates\AwardPointDatesQueryHandler;
use App\Domain\Entity\Pharmacy;
use App\Domain\Service\Finder\ReadModel\PharmacyReadFinderInterface;
use App\Domain\Service\Finder\ReadModel\PointReadFinderInterface;
use App\Domain\ValueObj\AwardedAt;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AwardPointDatesQueryHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_callable()
    {
        $pharmacyFinder   = $this->getDoublePharmacyFinder();
        $pointCountFinder = $this->getDoublePointCountFinder();

        $handler  = new AwardPointDatesQueryHandler($pharmacyFinder, $pointCountFinder);
        $count    = $handler($this->getCommand());

        self::assertIsInt($count);
    }


    private function getDoublePharmacyFinder(): PharmacyReadFinderInterface
    {
        $pharmacyFinder = m::mock(PharmacyReadFinderInterface::class);
        $pharmacyFinder
            ->shouldReceive('findOneOrFailByUuid')
            ->andReturn($this->getDoublePharmacy());

        return $pharmacyFinder;
    }


    private function getDoublePharmacy(): Pharmacy
    {
        return m::mock(Pharmacy::class);
    }


    private function getDoublePointCountFinder(): PointReadFinderInterface
    {
        $pointCountFinder = m::mock(PointReadFinderInterface::class);
        $pointCountFinder
            ->shouldReceive('countAwardPointsBetweenDates')
            ->andReturn(3);

        return $pointCountFinder;
    }


    private function getCommand(): AwardPointDatesQuery
    {
        $pharmacyUuid = Uuid::uuid4();
        $dateInit     = AwardedAt::now();
        $dateEnd      = AwardedAt::now();

        return new AwardPointDatesQuery($pharmacyUuid->toString(), $dateInit->toStr(), $dateEnd->toStr());
    }
}
