<?php

declare(strict_types=1);

namespace App\Domain\Event\Common;

use App\Domain\ValueObj\CreatedAt;

abstract class AbstractEvent implements EventInterface
{
    public CreatedAt $occurredOn;


    public function __construct()
    {
        $this->occurredOn = CreatedAt::now();
    }

    abstract protected function index(): string;

    abstract protected function payload(): array;


    public function serialize(): string
    {
        $data = [
            'event'      => static::eventName(),
            'id'         => $this->index(),
            'payload'    => $this->payload(),
            'occurredOn' => $this->occurredOn->toStr(),
        ];

        return json_encode($data);
    }


    public static function eventName(): string
    {
        $name = explode('\\', static::class);

        return end($name);
    }
}
