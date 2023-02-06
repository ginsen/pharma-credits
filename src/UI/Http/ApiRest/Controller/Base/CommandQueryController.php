<?php

declare(strict_types=1);

namespace App\UI\Http\ApiRest\Controller\Base;

use App\Infrastructure\EventSubscriber\LoaderEventSubscribers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class CommandQueryController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $queryBus,
        private readonly MessageBusInterface $commandBus,
        LoaderEventSubscribers $loaderSubscribers
    ) {
        unset($loaderSubscribers);
    }


    protected function commandHandler($command)
    {
        $envelope = $this->commandBus->dispatch($command);

        return ($envelope->last(HandledStamp::class))->getResult();
    }


    protected function queryHandler($query)
    {
        $envelope = $this->queryBus->dispatch($query);

        return ($envelope->last(HandledStamp::class))->getResult();
    }
}
