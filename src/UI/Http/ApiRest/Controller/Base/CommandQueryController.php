<?php

declare(strict_types=1);

namespace App\UI\Http\ApiRest\Controller\Base;

use App\Infrastructure\EventSubscriber\LoaderEventSubscribers;
use League\Tactician\CommandBus;

class CommandQueryController
{
    /** @var CommandBus */
    private $commandBus;

    /** @var CommandBus */
    private $queryBus;


    /**
     * CommandQueryController constructor.
     * @param CommandBus             $commandBus
     * @param CommandBus             $queryBus
     * @param LoaderEventSubscribers $loaderSubscribers
     */
    public function __construct(CommandBus $commandBus, CommandBus $queryBus, LoaderEventSubscribers $loaderSubscribers)
    {
        $this->commandBus = $commandBus;
        $this->queryBus   = $queryBus;

        unset($loaderSubscribers);
    }


    protected function handleCommand($command)
    {
        return $this->commandBus->handle($command);
    }


    protected function handleQuery($query)
    {
        return $this->queryBus->handle($query);
    }
}
