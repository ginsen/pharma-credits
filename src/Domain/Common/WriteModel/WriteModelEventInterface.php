<?php

declare(strict_types=1);

namespace App\Domain\Common\WriteModel;

use App\Domain\Event\Event\EventInterface;

interface WriteModelEventInterface
{
    public function queueToPersist($entity, EventInterface $event): void;

    public function persist(): void;

    public function clearQueue(): void;
}