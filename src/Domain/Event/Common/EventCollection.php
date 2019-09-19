<?php

declare(strict_types=1);

namespace App\Domain\Event\Common;

use Doctrine\Common\Collections\ArrayCollection;

class EventCollection
{
    /** @var self|null */
    private static $instance = null;

    /** @var ArrayCollection */
    private $events;


    /**
     * @return EventCollection|null
     */
    public static function instance(): self
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }


    /**
     * EventCollection constructor.
     */
    private function __construct()
    {
        $this->events = new ArrayCollection();
    }


    public function __clone()
    {
        throw new \BadMethodCallException('Clone is not supported');
    }


    public function reset(): void
    {
        $this->events = new ArrayCollection();
    }


    /**
     * @return ArrayCollection
     */
    public function events(): ArrayCollection
    {
        return $this->events;
    }


    /**
     * @param EventInterface $event
     */
    public function add(EventInterface $event): void
    {
        $this->events->add($event);
    }


    /**
     * @param EventInterface $event
     */
    public function remove(EventInterface $event): void
    {
        $this->events->removeElement($event);
    }
}
