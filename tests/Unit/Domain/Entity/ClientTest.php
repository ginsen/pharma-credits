<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Entity;

use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Entity\Point;
use App\Domain\Exception\ClientException;
use App\Domain\Exception\PointException;
use App\Domain\ValueObj\AwardedAt;
use App\Domain\ValueObj\ClientName;
use App\Domain\ValueObj\PharmacyName;
use App\Domain\ValueObj\QuantityPoints;
use App\Domain\ValueObj\RedeemedAt;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_create_one_instance(): void
    {
        $uuid   = Uuid::uuid4();
        $name   = ClientName::fromStr('test client');
        $client = Client::create($uuid, $name);

        self::assertInstanceOf(Client::class, $client);
    }


    /**
     * @test
     */
    public function it_should_return_name_and_uuid(): void
    {
        $uuid   = Uuid::uuid4();
        $name   = ClientName::fromStr('test client');
        $client = Client::create($uuid, $name);

        self::assertSame($uuid->toString(), $client->uuid()->toString());
        self::assertSame($name->toStr(), $client->name()->toStr());
    }


    /**
     * @test
     */
    public function it_should_return_only_available_points(): void
    {
        $uuid   = Uuid::uuid4();
        $name   = ClientName::fromStr('test client');
        $client = Client::create($uuid, $name);

        $this->addPoints($client, 2);
        self::assertSame(2, $client->getCountAvailablePoints());

        foreach ($client->points(QuantityPoints::fromInt(1)) as $point) {
            $point->redeem($point->pharmacyAwarding(), RedeemedAt::now());
        }

        self::assertSame(1, $client->getCountAvailablePoints());
    }


    /**
     * @test
     */
    public function it_should_return_partial_quantity_of_available_points(): void
    {
        $uuid   = Uuid::uuid4();
        $name   = ClientName::fromStr('test client');
        $client = Client::create($uuid, $name);

        $this->addPoints($client, 5);
        self::assertSame(5, $client->getCountAvailablePoints());
        self::assertCount(3, $client->points(QuantityPoints::fromInt(3)));
    }


    /**
     * @test
     */
    public function it_should_launch_exception_when_require_invalid_quantity_points(): void
    {
        $this->expectException(ClientException::class);

        $uuid   = Uuid::uuid4();
        $name   = ClientName::fromStr('test client');
        $client = Client::create($uuid, $name);

        $this->addPoints($client, 2);
        $client->points(QuantityPoints::fromInt(3));
    }


    /**
     * @test
     */
    public function it_should_launch_exception_when_add_invalid_point(): void
    {
        $this->expectException(PointException::class);

        $uuid   = Uuid::uuid4();
        $name   = ClientName::fromStr('test client');
        $client = Client::create($uuid, $name);

        $point = $this->createBadPoint();
        $client->addPoint($point);
    }


    /**
     * @param Client      $client
     * @param int         $number
     * @param string|null $date
     */
    protected function addPoints(Client $client, int $number, string $date = null): void
    {
        $pharmacy = Pharmacy::create(Uuid::uuid4(), PharmacyName::fromStr('pharmacy test'));
        $time     = (empty($date)) ? AwardedAt::now() : AwardedAt::fromStr($date);

        while ($number > 0) {
            --$number;
            Point::createAwardPoint($client, $pharmacy, $time);
        }
    }


    protected function createBadPoint(): Point
    {
        return new class() extends Point {
            public function __construct()
            {
                parent::__construct();
            }

            public function isAvailableForClient(): bool
            {
                return false;
            }
        };
    }
}
