<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Service\Finder\ReadModel;

use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\Entity\Pharmacy;
use App\Domain\Exception\PharmacyException;
use App\Domain\Repository\ReadModel\PharmacyReadModelInterface;
use App\Domain\Service\Finder\ReadModel\PharmacyReadFinder;
use App\Domain\Specification\PharmacySpecificationFactoryInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class PharmacyReadFinderTest extends TestCase implements PharmacyReadModelInterface, PharmacySpecificationFactoryInterface
{
    protected ?Pharmacy $pharmacy;


    /**
     * @test
     */
    public function it_should_return_exception_when_not_found_pharmacy()
    {
        $this->expectException(PharmacyException::class);
        $this->pharmacy = null;

        $finder = new PharmacyReadFinder($this, $this);
        $finder->findOneOrFailByUuid(Uuid::uuid4());
    }


    /**
     * @test
     */
    public function it_should_return_one_pharmacy()
    {
        $this->pharmacy = m::mock(Pharmacy::class);

        $uuid   = Uuid::uuid4();
        $finder = new PharmacyReadFinder($this, $this);

        self::assertSame($this->pharmacy, $finder->findOneOrFailByUuid($uuid));
    }



    public function findOneOrNull(SpecificationInterface $specification): ?Pharmacy
    {
        return $this->pharmacy;
    }


    public function createForFindOneWithUuid(UuidInterface $uuid): SpecificationInterface
    {
        return m::mock(SpecificationInterface::class);
    }
}
