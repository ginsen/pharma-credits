<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Event\Event;

use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Entity\Point;
use App\Domain\Event\Common\EventInterface;
use App\Domain\Event\Event\PointWasRedeemed;
use App\Domain\ValueObj\AwardedAt;
use App\Domain\ValueObj\ClientName;
use App\Domain\ValueObj\PharmacyName;
use App\Domain\ValueObj\RedeemedAt;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PointWasRedeemedTest extends TestCase
{
    protected static ?Point $point;


    public static function setUpBeforeClass(): void
    {
        $client     = self::getClient();
        $pharmacy   = self::getPharmacy();
        $awardedAt  = AwardedAt::now();
        $redeemedAt = RedeemedAt::now();

        self::$point = Point::createAwardPoint($client, $pharmacy, $awardedAt);
        self::$point->redeem($pharmacy, $redeemedAt);
    }


    public static function tearDownAfterClass(): void
    {
        self::$point = null;
    }


    /**
     * @test
     */
    public function it_should_event_instance()
    {
        $event = new PointWasRedeemed(self::$point);
        self::assertInstanceOf(EventInterface::class, $event);
    }


    /**
     * @test
     */
    public function it_should_serializable()
    {
        $event = new PointWasRedeemed(self::$point);
        self::assertIsString($event->serialize());
    }


    protected static function getClient(): Client
    {
        return Client::create(Uuid::uuid4(), ClientName::fromStr('client'));
    }


    protected static function getPharmacy(): Pharmacy
    {
        return Pharmacy::create(Uuid::uuid4(), PharmacyName::fromStr('test'));
    }
}
