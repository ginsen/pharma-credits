<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Entity;

use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Entity\Point;
use App\Domain\ValueObj\AwardedAt;
use App\Domain\ValueObj\ClientName;
use App\Domain\ValueObj\PharmacyName;
use App\Domain\ValueObj\RedeemedAt;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PharmacyTest extends TestCase
{
    /**
     * @test
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
     */
    public function it_should_return_name_and_uuid()
    {
        $uuid     = Uuid::uuid4();
        $name     = PharmacyName::fromStr('pharmacy test');
        $pharmacy = Pharmacy::create($uuid, $name);

        self::assertSame($uuid->toString(), $pharmacy->uuid()->toString());
        self::assertSame($name->toStr(), $pharmacy->name()->toStr());
    }


    /**
     * @test
     */
    public function it_should_obtain_awarded_points()
    {
        $uuid     = Uuid::uuid4();
        $name     = PharmacyName::fromStr('pharmacy test');
        $pharmacy = Pharmacy::create($uuid, $name);

        $this->addPoints($pharmacy, 2);
        self::assertCount(2, $pharmacy->awardedPoints());
    }


    /**
     * @test
     */
    public function it_should_obtain_redeemed_points()
    {
        $uuid     = Uuid::uuid4();
        $name     = PharmacyName::fromStr('pharmacy test');
        $pharmacy = Pharmacy::create($uuid, $name);

        $this->addPoints($pharmacy, 2);

        foreach ($pharmacy->awardedPoints() as $point) {
            $point->redeem($pharmacy, RedeemedAt::now());
        }

        self::assertCount(2, $pharmacy->redeemedPoints());
    }


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
