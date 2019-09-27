<?php

declare(strict_types=1);

namespace App\Domain\Event\Projector;

use App\Domain\Event\Common\EventInterface;
use App\Domain\Event\Subscriber\DomainEventSubscriberInterface;

abstract class EventProjector implements DomainEventSubscriberInterface
{
    public function handle(EventInterface $event, $data = null): void
    {
        $method = 'apply' . $event::eventName();
        if (method_exists($this, $method)) {
            $this->$method($event, $data);
        }
    }
}
