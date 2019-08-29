<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObj;

use App\Domain\ValueObj\ClientName;
use Assert\AssertionFailedException;
use PHPUnit\Framework\TestCase;

class ClientNameTest extends TestCase
{
    /**
     * @test
     * @throws AssertionFailedException
     */
    public function it_should_return_name()
    {
        $name = ClientName::fromStr('Jose');

        self::assertSame('Jose', $name->toStr());
        self::assertSame('Jose', (string) $name);
    }


    /**
     * @test
     * @throws AssertionFailedException
     */
    public function it_should_launch_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        ClientName::fromStr('Nunc quoniam ita accidit ut neque praetores suis opibus neque');
    }
}
