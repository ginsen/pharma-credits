<?php

declare(strict_types=1);

namespace App\Domain\Event\Publisher;

use App\Domain\Event\Event\EventInterface;
use App\Domain\Event\Subscriber\DomainEventSubscriberInterface;

class DomainEventPublisher
{
    /** @var DomainEventSubscriberInterface[] */
    private $subscribers;


    /**
     * DomainEventPublisher constructor.
     */
    public function __construct()
    {
        $this->subscribers = [];
    }


    public function subscribe(DomainEventSubscriberInterface $domainEventSubscriber)
    {
        $this->subscribers[] = $domainEventSubscriber;
    }


    public function publish(EventInterface $event)
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->handle($event);
        }
    }
}
