<?php

declare(strict_types=1);

namespace App\Domain\Event\Common;

interface EventInterface
{
    public function serialize(): string;

    public static function eventName(): string;
}
