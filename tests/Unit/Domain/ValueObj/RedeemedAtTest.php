<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\ValueObj;

use App\Domain\ValueObj\RedeemedAt;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class RedeemedAtTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_be_build_by_valid_datetime(): void
    {
        $time = RedeemedAt::now();
        self::assertInstanceOf(RedeemedAt::class, $time);
        self::assertInstanceOf(DateTimeImmutable::class, $time->toDateTime());
    }
}
