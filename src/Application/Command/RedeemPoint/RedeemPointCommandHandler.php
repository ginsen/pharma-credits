<?php

declare(strict_types=1);

namespace App\Application\Command\RedeemPoint;

use App\Domain\Service\Finder\WriteModel\ClientWriteFinderInterface;
use App\Domain\Service\Finder\WriteModel\PharmacyWriteFinderInterface;

class RedeemPointCommandHandler
{
    public function __construct(
        private readonly ClientWriteFinderInterface $clientFinder,
        private readonly PharmacyWriteFinderInterface $pharmacyFinder
    ) {
    }


    public function __invoke(RedeemPointCommand $command): void
    {
        $client   = $this->clientFinder->findOneOrFailByUuid($command->clientUuid());
        $pharmacy = $this->pharmacyFinder->findOneOrFailByUuid($command->pharmacyUuid());
        $points   = $client->points($command->quantity());

        foreach ($points as $point) {
            $point->redeem($pharmacy, $command->redeemedAt());
        }
    }
}
