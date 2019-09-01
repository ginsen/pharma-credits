<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Service;

use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Repository\PointReadModelInterface;
use App\Domain\Service\PointCountFinder;
use App\Domain\Specification\PointSpecificationFactoryInterface;
use App\Domain\ValueObj\AwardedAt;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class PointCountFinderTest extends TestCase implements PointSpecificationFactoryInterface
{
    /**
     * @test
     */
    public function it_should_return_int_when_find_between_dates()
    {
        $readModel = $this->getPointReadModel();
        $pharmacy  = m::mock(Pharmacy::class);
        $dateInit  = AwardedAt::now();
        $dateEnd   = AwardedAt::now();

        $finder = new PointCountFinder($readModel, $this);
        self::assertIsInt($finder->countAwardPointsBetweenDates($pharmacy, $dateInit, $dateEnd));
    }


    /**
     * @test
     */
    public function it_should_return_int_when_find_client()
    {
        $readModel = $this->getPointReadModel();
        $pharmacy  = m::mock(Pharmacy::class);
        $client    = m::mock(Client::class);

        $finder = new PointCountFinder($readModel, $this);
        self::assertIsInt($finder->countAwardPointsClient($pharmacy, $client));
    }


    private function getPointReadModel(): PointReadModelInterface
    {
        $readModel = m::mock(PointReadModelInterface::class);
        $readModel->shouldReceive('getCount')->andReturn(1);

        return $readModel;
    }

    public function createForCountPointsByPharmacyAndClient(Pharmacy $pharmacy, Client $client): SpecificationInterface
    {
        return m::mock(SpecificationInterface::class);
    }

    public function createForCountPointsByPharmacyBetweenDates(Pharmacy $pharmacy, AwardedAt $dateIni, AwardedAt $dateEnd): SpecificationInterface
    {
        return m::mock(SpecificationInterface::class);
    }
}
