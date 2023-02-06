<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\ValueObj;

use App\Domain\Exception\DateTimeException;
use App\Domain\ValueObj\AwardedAt;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class AwardedAtTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_be_build_by_valid_datetime(): void
    {
        $time = AwardedAt::now();
        self::assertInstanceOf(AwardedAt::class, $time);
        self::assertInstanceOf(DateTimeImmutable::class, $time->toDateTime());
        self::assertIsString((string) $time);
    }


    /**
     * @test
     */
    public function it_should_exception_when_receive_bad_format(): void
    {
        $this->expectException(DateTimeException::class);

        AwardedAt::fromStr('foobar');
    }
}
