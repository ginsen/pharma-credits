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

class PointTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_create_award_point()
    {
        $client    = $this->makeClient('client test');
        $pharmacy  = $this->makePharmacy('pharmacy test');
        $awardedAt = AwardedAt::now();

        $point = Point::createAwardPoint($client, $pharmacy, $awardedAt);

        self::assertInstanceOf(Point::class, $point);
        self::assertTrue($point->isAvailableForClient());
    }


    /**
     * @test
     */
    public function it_should_can_be_redeeming()
    {
        $client    = $this->makeClient('client test');
        $pharmacy  = $this->makePharmacy('pharmacy on awarding');
        $awardedAt = AwardedAt::now();

        $point = Point::createAwardPoint($client, $pharmacy, $awardedAt);

        $pharmacyOnRedeeming = $this->makePharmacy('pharmacy on redeeming');
        $redeemedAt          = RedeemedAt::now();

        $point->redeem($pharmacyOnRedeeming, $redeemedAt);

        self::assertFalse($point->isAvailableForClient());
    }


    /**
     * @test
     */
    public function it_should_return_pharmacy_on_awarding()
    {
        $client    = $this->makeClient('client test');
        $pharmacy  = $this->makePharmacy('pharmacy on awarding');
        $awardedAt = AwardedAt::now();

        $point = Point::createAwardPoint($client, $pharmacy, $awardedAt);
        self::assertSame($pharmacy, $point->pharmacyAwarding());
    }


    /**
     * @test
     */
    public function it_should_return_pharmacy_on_redeeming()
    {
        $client    = $this->makeClient('client test');
        $pharmacy  = $this->makePharmacy('pharmacy on awarding');
        $awardedAt = AwardedAt::now();

        $point = Point::createAwardPoint($client, $pharmacy, $awardedAt);
        self::assertSame($pharmacy, $point->pharmacyAwarding());

        $pharmacyOnRedeeming = $this->makePharmacy('pharmacy on redeeming');
        $redeemedAt          = RedeemedAt::now();

        $point->redeem($pharmacyOnRedeeming, $redeemedAt);

        self::assertSame($pharmacyOnRedeeming, $point->pharmacyRedeeming());
    }


    /**
     * @test
     */
    public function it_should_return_user_of_point()
    {
        $client    = $this->makeClient('client test');
        $pharmacy  = $this->makePharmacy('pharmacy on awarding');
        $awardedAt = AwardedAt::now();

        $point = Point::createAwardPoint($client, $pharmacy, $awardedAt);
        self::assertSame($client, $point->client());
    }


    protected function makeClient(string $name): Client
    {
        return Client::create(Uuid::uuid4(), ClientName::fromStr($name));
    }


    protected function makePharmacy(string $name): Pharmacy
    {
        return Pharmacy::create(Uuid::uuid4(), PharmacyName::fromStr($name));
    }
}
