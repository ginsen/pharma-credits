<?php

declare(strict_types=1);

namespace App\Domain\Event\Event;

use App\Domain\ValueObj\CreatedAt;

abstract class AbstractEvent implements EventInterface
{
    /** @var CreatedAt */
    public $occurredOn;


    /**
     * AbstractEvent constructor.
     */
    public function __construct()
    {
        $this->occurredOn = CreatedAt::now();
    }


    /**
     * @return string[]
     */
    abstract protected function payload(): array;


    /**
     * @return string
     */
    public function serialize(): string
    {
        $data = [
            'event'      => $this->getName(),
            'occurredOn' => $this->occurredOn->toStr(),
            'payload'    => $this->payload(),
        ];

        return json_encode($data);
    }


    /**
     * @return string
     */
    protected function getName(): string
    {
        $name = explode('\\', static::class);

        return end($name);
    }
}
