<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\ValueObj;

use App\Domain\ValueObj\QuantityPoints;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class QuantityPointsTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_return_integer()
    {
        $quantity = QuantityPoints::fromInt(7);

        self::assertInstanceOf(QuantityPoints::class, $quantity);
        self::assertSame(7, $quantity->toInt());
        self::assertSame('7', (string) $quantity);
    }


    /**
     * @test
     */
    public function it_should_launch_exception_when_number_is_zero()
    {
        $this->expectException(InvalidArgumentException::class);

        QuantityPoints::fromInt(0);
    }
}
