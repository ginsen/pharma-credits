<?php

declare(strict_types=1);

namespace App\Application\Command\CreatePoint;

use App\Domain\Entity\Point;
use App\Domain\Service\Finder\WriteModel\ClientWriteFinderInterface;
use App\Domain\Service\Finder\WriteModel\PharmacyWriteFinderInterface;

class CreatePointCommandHandler
{
    public function __construct(
        private readonly ClientWriteFinderInterface $clientFinder,
        private readonly PharmacyWriteFinderInterface $pharmacyFinder
    ) {
    }


    public function __invoke(CreatePointCommand $command): void
    {
        $client   = $this->clientFinder->findOneOrFailByUuid($command->clientUuid());
        $pharmacy = $this->pharmacyFinder->findOneOrFailByUuid($command->pharmacyUuid());

        for ($i = 0; $command->quantity()->toInt() > $i; ++$i) {
            Point::createAwardPoint($client, $pharmacy, $command->awardedAt());
        }
    }
}
