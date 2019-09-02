<?php

declare(strict_types=1);

namespace App\Application\Command\RedeemPoint;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\Common\WriteModel\WriteModelInterface;
use App\Domain\Service\ClientFinderInterface;
use App\Domain\Service\PharmacyFinderInterface;

class RedeemPointHandler implements CommandHandlerInterface
{
    /** @var ClientFinderInterface */
    private $clientFinder;

    /** @var PharmacyFinderInterface */
    private $pharmacyFinder;

    /** @var WriteModelInterface */
    private $writeModel;


    public function __construct(
        ClientFinderInterface $clientFinder,
        PharmacyFinderInterface $pharmacyFinder,
        WriteModelInterface $writeModel
    ) {
        $this->clientFinder   = $clientFinder;
        $this->pharmacyFinder = $pharmacyFinder;
        $this->writeModel     = $writeModel;
    }


    public function __invoke(RedeemPointCommand $command): void
    {
        $client   = $this->clientFinder->findOneOrFailByUuid($command->clientUuid);
        $pharmacy = $this->pharmacyFinder->findOneOrFailByUuid($command->pharmacyUuid);
        $points   = $client->getPoints($command->quantity);

        foreach ($points as $point) {
            $point->redeem($pharmacy, $command->redeemedAt);
            $this->writeModel->queueToPersist($point);
        }

        $this->writeModel->persist();
    }
}
