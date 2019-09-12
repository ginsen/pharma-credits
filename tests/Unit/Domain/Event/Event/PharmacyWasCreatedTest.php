<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Event\Event;

use App\Domain\Entity\Pharmacy;
use App\Domain\Event\Event\EventInterface;
use App\Domain\Event\Event\PharmacyWasCreated;
use App\Domain\ValueObj\PharmacyName;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PharmacyWasCreatedTest extends TestCase
{
    /** @var Pharmacy */
    private static $pharmacy;


    /**
     * {@inheritdoc}
     * @throws \Exception|\Assert\AssertionFailedException
     */
    public static function setUpBeforeClass()
    {
        self::$pharmacy = self::getPharmacy();
    }


    /**
     * {@inheritdoc}
     */
    public static function tearDownAfterClass()
    {
        self::$pharmacy = null;
    }


    /**
     * @test
     */
    public function it_should_event_instance()
    {
        $event = new PharmacyWasCreated(self::$pharmacy);
        self::assertInstanceOf(EventInterface::class, $event);
    }


    /**
     * @test
     */
    public function it_should_serializable()
    {
        $event = new PharmacyWasCreated(self::$pharmacy);
        self::assertIsString($event->serialize());
    }


    /**
     * @throws \Exception|\Assert\AssertionFailedException
     * @return Pharmacy
     */
    protected static function getPharmacy(): Pharmacy
    {
        return Pharmacy::create(Uuid::uuid4(), PharmacyName::fromStr('test'));
    }
}
