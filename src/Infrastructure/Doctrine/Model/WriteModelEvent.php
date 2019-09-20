<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Model;

use App\Domain\Common\WriteModel\WriteModelInterface;
use App\Domain\Event\Common\EventCollection;
use App\Domain\Event\Publisher\DomainEventPublisher;

class WriteModelEvent implements WriteModelInterface
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
     */
    public function __construct(WriteModelInterface $writeModel)
    {
        $this->writeModel     = $writeModel;
        $this->eventPublisher = DomainEventPublisher::instance();
        $this->events         = EventCollection::instance();
    }


    public function queueToPersist($entity): void
    {
        $this->writeModel->queueToPersist($entity);
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
