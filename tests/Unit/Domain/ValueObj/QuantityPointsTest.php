<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObj;

use App\Domain\ValueObj\QuantityPoints;
use Assert\AssertionFailedException;
use PHPUnit\Framework\TestCase;

class QuantityPointsTest extends TestCase
{
    /**
     * @test
     * @throws AssertionFailedException
     */
    public function it_should_return_integer()
    {
        $quantity = QuantityPoints::fromInt(7);

        self::assertInstanceOf(QuantityPoints::class, $quantity);
        self::assertSame(7, $quantity->toNumber());
    }


    /**
     * @test
     * @throws AssertionFailedException
     */
    public function it_should_launch_exception_when_number_is_zero()
    {
        $this->expectException(\InvalidArgumentException::class);

        QuantityPoints::fromInt(0);
    }
}
