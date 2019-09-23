<?php

declare(strict_types=1);

namespace App\Domain\Event\Publisher;

use App\Domain\Event\Common\EventInterface;
use App\Domain\Event\Subscriber\DomainEventSubscriberInterface;

/**
 * Class DomainEventPublisher
 */
class DomainEventPublisher
{
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
        $this->subscribers = [];
    }


    public function __clone()
    {
        throw new \BadMethodCallException('Clone is not supported');
    }


    public function subscribe(DomainEventSubscriberInterface $subscriber): void
    {
        $this->subscribers = $subscriber;
    }


    public function publish(EventInterface $event, $data = null)
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->handle($event, $data);
        }
    }
}
