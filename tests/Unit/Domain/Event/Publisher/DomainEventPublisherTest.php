<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Event\Publisher;

use App\Domain\Event\Common\EventInterface;
use App\Domain\Event\Publisher\DomainEventPublisher;
use App\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use BadMethodCallException;
use PHPUnit\Framework\TestCase;

class DomainEventPublisherTest extends TestCase implements DomainEventSubscriberInterface, EventInterface
{
    private bool $handleSubscriber = false;


    /**
     * @test
     */
    public function it_should_added_subscriber_and_publish_event()
    {
        $domainEventPublisher = DomainEventPublisher::instance();
        $domainEventPublisher->subscribe($this);

        $domainEventPublisher->publish($this);
        self::assertTrue($this->handleSubscriber);
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_clone_it()
    {
        $this->expectException(BadMethodCallException::class);

        $eventPublisher = DomainEventPublisher::instance();
        $clone          = clone $eventPublisher;
        unset($clone);
    }


    public function handle(EventInterface $event, $data = null): void
    {
        $this->handleSubscriber = true;
    }


    public function serialize(): string
    {
        return '';
    }


    public static function eventName(): string
    {
        return 'event';
    }
}
