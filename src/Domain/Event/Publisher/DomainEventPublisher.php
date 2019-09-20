<?php

declare(strict_types=1);

namespace App\Domain\Event\Publisher;

use App\Domain\Event\Common\EventInterface;
use App\Domain\Event\Subscriber\DomainEventSubscriberInterface;

/**
 * Class DomainEventPublisher
 * Patterns [Mediator, Singleton]
 */
class DomainEventPublisher
{
    const ALL_EVENTS = '*';


    /** @var self|null */
    private static $instance = null;

    /** @var array */
    private $subscribers;


    /**
     * @return DomainEventPublisher
     */
    public static function instance(): self
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }


    /**
     * DomainEventPublisher constructor.
     */
    private function __construct()
    {
        $this->subscribers[self::ALL_EVENTS] = [];
    }


    public function __clone()
    {
        throw new \BadMethodCallException('Clone is not supported');
    }


    public function subscribe(DomainEventSubscriberInterface $subscriber, string $event = self::ALL_EVENTS): void
    {
        $this->initEventGroup($event);
        $this->subscribers[$event][] = $subscriber;
    }


    public function unsubscribe(DomainEventSubscriberInterface $subscriber, string $event = self::ALL_EVENTS): void
    {
        foreach ($this->getSubscribers($event) as $key => $observer) {
            if ($observer === $subscriber) {
                unset($this->subscribers[$event][$key]);
            }
        }
    }


    public function publish(EventInterface $event)
    {
        foreach ($this->getSubscribers($event->getName()) as $subscriber) {
            $subscriber->handle($event);
        }
    }


    private function initEventGroup(string $event): void
    {
        if (!isset($this->subscribers[$event])) {
            $this->subscribers[$event] = [];
        }
    }


    private function getSubscribers(string $event): array
    {
        $this->initEventGroup($event);

        $group = $this->subscribers[$event];
        $all   = $this->subscribers[self::ALL_EVENTS];

        return array_merge($group, $all);
    }
}
