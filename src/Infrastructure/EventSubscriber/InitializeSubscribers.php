<?php

declare(strict_types=1);

namespace App\Infrastructure\EventSubscriber;

use App\Domain\Event\Publisher\DomainEventPublisher;
use App\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use Symfony\Component\Yaml\Yaml;

class InitializeSubscribers
{
    /** @var DomainEventPublisher */
    private $publisher;


    public function __construct()
    {
        $this->publisher = DomainEventPublisher::instance();
    }


    public function loadSubscriber(DomainEventSubscriberInterface $subscriber): void
    {
        $this->publisher->subscribe($subscriber);
    }
}