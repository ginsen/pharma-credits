<?php

declare(strict_types=1);

namespace App\Infrastructure\EventSubscriber;

use App\Domain\Event\Publisher\DomainEventPublisher;
use Symfony\Component\Yaml\Yaml;

class InitializeSubscribers
{
    /** @var array */
    private $config;

    private $publisher;


    public function __construct(string $configFile)
    {
        $this->config    = Yaml::parseFile($configFile);
        $this->publisher = DomainEventPublisher::instance();

        $this->loadSubscribers();
    }


    private function loadSubscribers(): void
    {
        dump($this->config);
    }
}