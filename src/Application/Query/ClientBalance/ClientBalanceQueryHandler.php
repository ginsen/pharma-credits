<?php

declare(strict_types=1);

namespace App\Application\Query\ClientBalance;

use App\Domain\Service\Finder\ReadModel\ClientReadFinderInterface;

class ClientBalanceQueryHandler
{
    public function __construct(
        private readonly ClientReadFinderInterface $clientFinder
    ) {
    }


    public function __invoke(ClientBalanceQuery $command): int
    {
        $client = $this->clientFinder->findOneOrFailByUuid($command->clientUuid());

        return $client->getCountAvailablePoints();
    }
}
