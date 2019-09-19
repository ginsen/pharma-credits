<?php

declare(strict_types=1);

namespace App\Domain\Entity\AggregateRoot;

use App\Domain\Event\Common\EventCollection;
use App\Domain\Event\Common\EventInterface;

abstract class AggregateRoot
{
    public function queueEvent(EventInterface $event): void
    {
        EventCollection::instance()->add($event);
    }
}
