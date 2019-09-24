<?php

declare(strict_types=1);

namespace App\Infrastructure\EventSubscriber;

use App\Domain\Event\Publisher\DomainEventPublisher;
use App\Domain\Event\Subscriber\DomainEventSubscriberInterface;

class LoaderEventSubscribers
{
    public function load(DomainEventSubscriberInterface $subscriber): void
    {
        DomainEventPublisher::instance()->subscribe($subscriber);
    }
}
