<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Query\AwardPointDates;

use App\Application\Query\AwardPointDates\AwardPointDatesQuery;
use App\Domain\ValueObj\AwardedAt;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class AwardPointDatesQueryTest extends TestCase
{
    /**
     * @test
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
     */
    public function it_should_return_pharmacy_uuid()
    {
        $pharmacyUuid = Uuid::uuid4();
        $dateInit     = AwardedAt::now();
        $dateEnd      = AwardedAt::now();

        $command = new AwardPointDatesQuery($pharmacyUuid->toString(), $dateInit->toStr(), $dateEnd->toStr());
        self::assertInstanceOf(UuidInterface::class, $command->pharmacyUuid());
    }


    /**
     * @test
     */
    public function it_should_return_date_init()
    {
        $pharmacyUuid = Uuid::uuid4();
        $dateInit     = AwardedAt::now();
        $dateEnd      = AwardedAt::now();

        $command = new AwardPointDatesQuery($pharmacyUuid->toString(), $dateInit->toStr(), $dateEnd->toStr());
        self::assertInstanceOf(AwardedAt::class, $command->dateInit());
    }


    /**
     * @test
     */
    public function it_should_return_date_end()
    {
        $pharmacyUuid = Uuid::uuid4();
        $dateInit     = AwardedAt::now();
        $dateEnd      = AwardedAt::now();

        $command = new AwardPointDatesQuery($pharmacyUuid->toString(), $dateInit->toStr(), $dateEnd->toStr());
        self::assertInstanceOf(AwardedAt::class, $command->dateEnd());
    }


    /**
     * @test
     */
    public function it_should_refactor_date_end_when_dont_has_hours()
    {
        $pharmacyUuid = Uuid::uuid4();
        $dateInit     = AwardedAt::now();
        $dateEnd      = (AwardedAt::now())->toDateTime()->format('Y-m-d');

        $command = new AwardPointDatesQuery($pharmacyUuid->toString(), $dateInit->toStr(), $dateEnd);
        self::assertInstanceOf(AwardedAt::class, $command->dateEnd());
        self::assertMatchesRegularExpression('/T23:59:59/', $command->dateEnd()->toStr());
    }
}
