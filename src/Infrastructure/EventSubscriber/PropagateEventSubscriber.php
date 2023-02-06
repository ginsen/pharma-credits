<?php

declare(strict_types=1);

namespace App\Infrastructure\EventSubscriber;

use App\Domain\Entity\AggregateRoot\EntityInterface;
use App\Domain\Event\Common\EventInterface;
use App\Domain\Event\Projector\EventProjector;
use App\Domain\Event\Subscriber\DomainEventSubscriberInterface;

class PropagateEventSubscriber extends EventProjector implements DomainEventSubscriberInterface
{
    protected function applyPointWasCreated(EventInterface $event, $data = null): void
    {
        if ($data instanceof EntityInterface) {
            $this->notifyOutOfBoundedContext($event);
        }
    }


    protected function applyPointWasRedeemed(EventInterface $event, $data = null): void
    {
        if ($data instanceof EntityInterface) {
            $this->notifyOutOfBoundedContext($event);
        }
    }


    private function notifyOutOfBoundedContext(EventInterface $event): void
    {
        // todo: notifier out of bounded context, aka RabbitMQ
    }
}
