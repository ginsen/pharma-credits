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

class ClientTest extends TestCase
{
    /**
     * @test
     * @throws AssertionFailedException|\Exception
     */
    public function it_should_create_one_instance()
    {
        $uuid   = Uuid::uuid4();
        $name   = ClientName::fromStr('test client');
        $client = Client::create($uuid, $name);

        self::assertInstanceOf(Client::class, $client);
    }


    /**
     * @test
     * @throws AssertionFailedException|\Exception
     */
    public function it_should_return_name_and_uuid()
    {
        $uuid   = Uuid::uuid4();
        $name   = ClientName::fromStr('test client');
        $client = Client::create($uuid, $name);

        self::assertSame($uuid->toString(), $client->getUuid()->toString());
        self::assertSame($name->toStr(), $client->getName()->toStr());
    }


    /**
     * @test
     * @throws AssertionFailedException|\Exception
     */
    public function it_should_add_and_get_points()
    {
        $uuid   = Uuid::uuid4();
        $name   = ClientName::fromStr('test client');
        $client = Client::create($uuid, $name);

        $this->addPoints($client, 2);
        self::assertSame(2, $client->getCountAvailablePoints());
    }


    /**
     * @param Client $client
     * @param int    $number
     * @throws AssertionFailedException|\Exception
     */
    protected function addPoints(Client $client, int $number): void
    {
        $pharmacy = Pharmacy::create(Uuid::uuid4(), PharmacyName::fromStr('pharmacy test'));
        $time     = AwardedAt::now();

        while ($number > 0) {
            --$number;
            Point::createAwardPoint($client, $pharmacy, $time);
        }
    }
}
