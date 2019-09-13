<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Model;

use App\Domain\Common\WriteModel\WriteModelInterface;
use App\Domain\Event\Event\EventInterface;
use App\Domain\Event\Publisher\DomainEventPublisher;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

class WriteModel implements WriteModelInterface
{
    /** @var ObjectManager */
    private $manager;

    /** @var DomainEventPublisher */
    private $eventPublisher;

    /** @var ArrayCollection */
    private $events;


    /**
     * WriteModel constructor.
     * @param ObjectManager        $manager
     * @param DomainEventPublisher $eventPublisher
     */
    public function __construct(ObjectManager $manager, DomainEventPublisher $eventPublisher)
    {
        $this->manager        = $manager;
        $this->eventPublisher = $eventPublisher;
        $this->events         = new ArrayCollection();
    }


    public function queueToPersist($entity, EventInterface $event): void
    {
        $this->queueEvent($event);
        $this->manager->persist($entity);
    }


    public function persist(): void
    {
        $this->manager->flush();
        $this->publishEvents();
    }


    public function clearQueue(): void
    {
        $this->manager->clear();
        $this->clearEvents();
    }


    protected function queueEvent(EventInterface $event): void
    {
        $this->events->add($event);
    }


    protected function publishEvents(): void
    {
        foreach ($this->events as $event) {
            $this->eventPublisher->publish($event);
            $this->events->removeElement($event);
        }
    }


    protected function clearEvents(): void
    {
        $this->events = new ArrayCollection();
    }
}
