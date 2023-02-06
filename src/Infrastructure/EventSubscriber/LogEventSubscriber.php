<?php

declare(strict_types=1);

namespace App\Infrastructure\EventSubscriber;

use App\Domain\Event\Common\EventInterface;
use App\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use Psr\Log\LoggerInterface;

class LogEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }


    public function handle(EventInterface $event, $data = null): void
    {
        $this->logger->info($event->serialize());
    }
}
