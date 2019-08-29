<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObj;

use App\Domain\ValueObj\AwardedAt;
use PHPUnit\Framework\TestCase;

class AwardedAtTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_be_build_by_valid_datetime(): void
    {
        $time = AwardedAt::now();
        self::assertInstanceOf(\DateTimeImmutable::class, $time->toDateTime());
    }
}
