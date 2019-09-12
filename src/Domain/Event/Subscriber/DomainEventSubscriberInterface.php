<?php

declare(strict_types=1);

namespace App\Domain\Event\Subscriber;

use App\Domain\Event\Event\EventInterface;

interface DomainEventSubscriberInterface
{
    public function handle(EventInterface $event): void;
}
