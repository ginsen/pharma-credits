<?php

declare(strict_types=1);

namespace App\Domain\Event\Event;

use Doctrine\Common\Collections\ArrayCollection;

class EventCollection
{
    /** @var ArrayCollection */
    private $events;


    /**
     * EventCollection constructor.
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
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
