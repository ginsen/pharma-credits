<?php

declare(strict_types=1);

namespace App\Domain\Event\Event;

interface EventInterface
{
    public function serialize(): string;
}
