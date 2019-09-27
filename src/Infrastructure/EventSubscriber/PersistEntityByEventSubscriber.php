<?php

declare(strict_types=1);

namespace App\Infrastructure\EventSubscriber;

use App\Domain\Common\WriteModel\WriteModelInterface;
use App\Domain\Entity\AggregateRoot\EntityInterface;
use App\Domain\Event\Common\EventInterface;
use App\Domain\Event\Projector\EventProjector;
use App\Domain\Event\Subscriber\DomainEventSubscriberInterface;

class PersistEntityByEventSubscriber extends EventProjector implements DomainEventSubscriberInterface
{
    /** @var WriteModelInterface */
    private $writeModel;


    public function __construct(WriteModelInterface $writeModel)
    {
        $this->writeModel = $writeModel;
    }


    protected function applyPointWasCreated(EventInterface $event, $data = null): void
    {
        if ($data instanceof EntityInterface) {
            $this->writeModel->save($data);
            $this->notifyOutOfBoundedContext($event);
        }
    }


    protected function applyPointWasRedeemed(EventInterface $event, $data = null): void
    {
        if ($data instanceof EntityInterface) {
            $this->writeModel->update($data);
            $this->notifyOutOfBoundedContext($event);
        }
    }


    /**
     * @param EventInterface $event
     */
    private function notifyOutOfBoundedContext(EventInterface $event): void
    {
        //todo: notifier out of bounded context, aka RabbitMQ
    }
}
