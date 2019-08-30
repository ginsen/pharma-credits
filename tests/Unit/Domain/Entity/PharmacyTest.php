<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Entity;

use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Entity\Point;
use App\Domain\ValueObj\AwardedAt;
use App\Domain\ValueObj\ClientName;
use App\Domain\ValueObj\PharmacyName;
use Assert\AssertionFailedException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PharmacyTest extends TestCase
{
    /**
     * @test
     * @throws AssertionFailedException|\Exception
     */
    public function it_should_create_one_instance()
    {
        $uuid     = Uuid::uuid4();
        $name     = PharmacyName::fromStr('pharmacy test');
        $pharmacy = Pharmacy::create($uuid, $name);

        self::assertInstanceOf(Pharmacy::class, $pharmacy);
    }


    /**
     * @test
     * @throws AssertionFailedException|\Exception
     */
    public function it_should_return_name_and_uuid()
    {
        $uuid     = Uuid::uuid4();
        $name     = PharmacyName::fromStr('pharmacy test');
        $pharmacy = Pharmacy::create($uuid, $name);

        self::assertSame($uuid->toString(), $pharmacy->getUuid()->toString());
        self::assertSame($name->toStr(), $pharmacy->getName()->toStr());
    }


    /**
     * @test
     * @throws AssertionFailedException|\Exception
     */
    public function it_should_add_remove_and_get_points()
    {
        $uuid     = Uuid::uuid4();
        $name     = PharmacyName::fromStr('pharmacy test');
        $pharmacy = Pharmacy::create($uuid, $name);

        $this->addPoints($pharmacy, 2);
        self::assertCount(2, $pharmacy->getDispensedPoints());

        $points = $pharmacy->getDispensedPoints();
        $pharmacy->removeDispensedPoint($points[0]);
        self::assertCount(1, $pharmacy->getDispensedPoints());
    }


    /**
     * @param Pharmacy $pharmacy
     * @param int      $number
     * @throws AssertionFailedException|\Exception
     */
    protected function addPoints(Pharmacy $pharmacy, int $number): void
    {
        $client = Client::create(Uuid::uuid4(), ClientName::fromStr('client test'));
        $time   = AwardedAt::now();

        while ($number > 0) {
            --$number;
            Point::createAwardPoint($client, $pharmacy, $time);
        }
    }
}
