<?php

declare(strict_types=1);

namespace App\Application\Query\ClientBalance;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Service\ClientFinderInterface;

class ClientBalanceHandler implements QueryHandlerInterface
{
    /** @var ClientFinderInterface */
    private $clientFinder;


    public function __construct(ClientFinderInterface $clientFinder)
    {
        $this->clientFinder = $clientFinder;
    }


    /**
     * @param ClientBalanceQuery $command
     * @return int
     */
    public function __invoke(ClientBalanceQuery $command): int
    {
        $client = $this->clientFinder->findOneOrFailByUuid($command->clientUuid);

        return $client->getCountAvailablePoints();
    }
}
