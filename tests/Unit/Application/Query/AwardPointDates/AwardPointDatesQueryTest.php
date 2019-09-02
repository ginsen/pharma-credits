<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Query\AwardPointDates;

use App\Application\Query\AwardPointDates\AwardPointDatesQuery;
use App\Domain\ValueObj\AwardedAt;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class AwardPointDatesQueryTest extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function it_should_create_one_instance()
    {
        $pharmacyUuid = Uuid::uuid4();
        $dateInit     = AwardedAt::now();
        $dateEnd      = AwardedAt::now();

        $command = new AwardPointDatesQuery($pharmacyUuid->toString(), $dateInit->toStr(), $dateEnd->toStr());

        self::assertInstanceOf(AwardPointDatesQuery::class, $command);
    }


    /**
     * @test
     * @throws \Exception
     */
    public function it_should_return_pharmacy_uuid()
    {
        $pharmacyUuid = Uuid::uuid4();
        $dateInit     = AwardedAt::now();
        $dateEnd      = AwardedAt::now();

        $command = new AwardPointDatesQuery($pharmacyUuid->toString(), $dateInit->toStr(), $dateEnd->toStr());
        self::assertInstanceOf(UuidInterface::class, $command->pharmacyUuid);
    }


    /**
     * @test
     * @throws \Exception
     */
    public function it_should_return_date_init()
    {
        $pharmacyUuid = Uuid::uuid4();
        $dateInit     = AwardedAt::now();
        $dateEnd      = AwardedAt::now();

        $command = new AwardPointDatesQuery($pharmacyUuid->toString(), $dateInit->toStr(), $dateEnd->toStr());
        self::assertInstanceOf(AwardedAt::class, $command->dateInit);
    }


    /**
     * @test
     * @throws \Exception
     */
    public function it_should_return_date_end()
    {
        $pharmacyUuid = Uuid::uuid4();
        $dateInit     = AwardedAt::now();
        $dateEnd      = AwardedAt::now();

        $command = new AwardPointDatesQuery($pharmacyUuid->toString(), $dateInit->toStr(), $dateEnd->toStr());
        self::assertInstanceOf(AwardedAt::class, $command->dateEnd);
    }
}
