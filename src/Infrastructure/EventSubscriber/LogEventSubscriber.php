<?php

declare(strict_types=1);

namespace App\Infrastructure\EventSubscriber;

use App\Domain\Event\Common\EventInterface;
use App\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use Psr\Log\LoggerInterface;

class LogEventSubscriber implements DomainEventSubscriberInterface
{
    /** @var LoggerInterface */
    private $logger;


    /**
     * LogEventSubscriber constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * @param EventInterface $event
     */
    public function handle(EventInterface $event): void
    {
        $this->logger->info($event->serialize());
    }
}
