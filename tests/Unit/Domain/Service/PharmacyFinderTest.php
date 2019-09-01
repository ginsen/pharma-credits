<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Service;

use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\Entity\Pharmacy;
use App\Domain\Exception\PharmacyException;
use App\Domain\Repository\PharmacyReadModelInterface;
use App\Domain\Service\PharmacyFinder;
use App\Domain\Specification\PharmacySpecificationFactoryInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class PharmacyFinderTest extends TestCase implements PharmacyReadModelInterface, PharmacySpecificationFactoryInterface
{
    protected $pharmacy;


    /**
     * @test
     * @throws \Exception
     */
    public function it_should_return_exception_when_not_found_pharmacy()
    {
        $this->expectException(PharmacyException::class);
        $this->pharmacy = null;

        $finder = new PharmacyFinder($this, $this);
        $finder->findOneOrFailByUuid(Uuid::uuid4());
    }


    /**
     * @test
     * @throws \Exception
     */
    public function it_should_return_one_pharmacy()
    {
        $this->pharmacy = m::mock(Pharmacy::class);

        $uuid   = Uuid::uuid4();
        $finder = new PharmacyFinder($this, $this);

        self::assertSame($this->pharmacy, $finder->findOneOrFailByUuid($uuid));
    }



    public function getOneOrNull(SpecificationInterface $specification): ?Pharmacy
    {
        return $this->pharmacy;
    }


    public function createForFindOneWithUuid(UuidInterface $uuid): SpecificationInterface
    {
        return m::mock(SpecificationInterface::class);
    }
}
