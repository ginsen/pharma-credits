<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\ValueObj;

use App\Domain\ValueObj\PharmacyName;
use PHPUnit\Framework\TestCase;

class PharmacyNameTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_return_name()
    {
        $name = PharmacyName::fromStr('Jose');

        self::assertSame('Jose', $name->toStr());
        self::assertSame('Jose', (string) $name);
    }


    /**
     * @test
     */
    public function it_should_launch_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        PharmacyName::fromStr('Nunc quoniam ita accidit ut neque praetores suis opibus neque nos nostro studio ets');
    }
}
