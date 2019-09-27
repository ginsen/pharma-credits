<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Event\Projector;

use App\Domain\Event\Common\EventInterface;
use App\Domain\Event\Projector\EventProjector;
use PHPUnit\Framework\TestCase;

class EventProjectorTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_call_apply_method(): void
    {
        $event     = $this->makeEvent();
        $projector = $this->makeProjector();

        $projector->handle($event);

        self::assertSame($projector->applyCalled, 1);
    }


    private function makeProjector()
    {
        return new class() extends EventProjector {
            public $applyCalled = 0;

            public function applyEventWasCalled(EventInterface $event, $data = null): void
            {
                ++$this->applyCalled;
            }
        };
    }


    private function makeEvent(): EventInterface
    {
        return new class() implements EventInterface {
            public function serialize(): string
            {
                return '';
            }

            public static function eventName(): string
            {
                return 'EventWasCalled';
            }
        };
    }
}
