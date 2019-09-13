<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Model;

use App\Domain\Common\WriteModel\WriteModelEventInterface;
use App\Domain\Common\WriteModel\WriteModelInterface;
use App\Domain\Event\Event\EventCollection;
use App\Domain\Event\Event\EventInterface;
use App\Domain\Event\Publisher\DomainEventPublisher;

class WriteModelEvent implements WriteModelEventInterface
{
    /** @var WriteModelInterface */
    private $writeModel;

    /** @var DomainEventPublisher */
    private $eventPublisher;

    /** @var EventCollection */
    private $events;


    /**
     * WriteModelEvent constructor.
     * @param WriteModelInterface  $writeModel
     * @param DomainEventPublisher $eventPublisher
     * @param EventCollection      $eventCollection
     */
    public function __construct(
        WriteModelInterface $writeModel,
        DomainEventPublisher $eventPublisher,
        EventCollection $eventCollection
    ) {
        $this->writeModel     = $writeModel;
        $this->eventPublisher = $eventPublisher;
        $this->events         = $eventCollection;
    }


    public function queueToPersist($entity, EventInterface $event): void
    {
        $this->writeModel->queueToPersist($entity);
        $this->events->add($event);
    }


    public function persist(): void
    {
        $this->writeModel->persist();
        $this->publishEvents();
    }


    protected function publishEvents(): void
    {
        foreach ($this->events->events() as $event) {
            $this->eventPublisher->publish($event);
            $this->events->remove($event);
        }
    }


    public function clearQueue(): void
    {
        $this->writeModel->clearQueue();
        $this->events->reset();
    }
}
