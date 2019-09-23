<?php

declare(strict_types=1);

namespace App\Application\Command\RedeemPoint;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\Service\ClientFinderInterface;
use App\Domain\Service\PharmacyFinderInterface;

class RedeemPointHandler implements CommandHandlerInterface
{
    /** @var ClientFinderInterface */
    private $clientFinder;

    /** @var PharmacyFinderInterface */
    private $pharmacyFinder;


    public function __construct(
        ClientFinderInterface $clientFinder,
        PharmacyFinderInterface $pharmacyFinder
    ) {
        $this->clientFinder   = $clientFinder;
        $this->pharmacyFinder = $pharmacyFinder;
    }


    public function __invoke(RedeemPointCommand $command): void
    {
        $client   = $this->clientFinder->findOneOrFailByUuid($command->clientUuid);
        $pharmacy = $this->pharmacyFinder->findOneOrFailByUuid($command->pharmacyUuid);
        $points   = $client->getPoints($command->quantity);

        foreach ($points as $point) {
            $point->redeem($pharmacy, $command->redeemedAt);
        }
    }
}
