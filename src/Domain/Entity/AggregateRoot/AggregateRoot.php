<?php

declare(strict_types=1);

namespace App\Domain\Entity\AggregateRoot;

use App\Domain\Event\Common\EventCollection;
use App\Domain\Event\Common\EventInterface;
use App\Domain\Event\Publisher\DomainEventPublisher;

abstract class AggregateRoot implements EntityInterface
{
    public function publish(EventInterface $event): void
    {
        DomainEventPublisher::instance()->publish($event, $this);
    }
}
