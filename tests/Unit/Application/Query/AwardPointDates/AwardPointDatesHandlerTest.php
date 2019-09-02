<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Query\AwardPointDates;

use App\Application\Query\AwardPointDates\AwardPointDatesHandler;
use App\Application\Query\AwardPointDates\AwardPointDatesQuery;
use App\Domain\Entity\Pharmacy;
use App\Domain\Service\PharmacyFinderInterface;
use App\Domain\Service\PointCountFinderInterface;
use App\Domain\ValueObj\AwardedAt;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Mockery as m;

class AwardPointDatesHandlerTest extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function it_should_callable()
    {
        $pharmacyFinder   = $this->getDoublePharmacyFinder();
        $pointCountFinder = $this->getDoublePointCountFinder();

        $handler  = new AwardPointDatesHandler($pharmacyFinder, $pointCountFinder);
        $count = $handler($this->getCommand());

        self::assertIsInt($count);
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
        $pointCountFinder->shouldReceive('countAwardPointsBetweenDates')->andReturn(3);

        return $pointCountFinder;
    }


    /**
     * @return AwardPointDatesQuery
     * @throws \Exception
     */
    private function getCommand(): AwardPointDatesQuery
    {
        $pharmacyUuid = Uuid::uuid4();
        $dateInit     = AwardedAt::now();
        $dateEnd      = AwardedAt::now();

        $command = new AwardPointDatesQuery($pharmacyUuid->toString(), $dateInit->toStr(), $dateEnd->toStr());

        return $command;
    }
}