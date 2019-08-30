<?php

declare(strict_types=1);

namespace App\Application\Command\ExchangePoint;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\Common\WriteModel\WriteModelInterface;
use App\Domain\Service\ClientFinder;
use App\Domain\Service\PharmacyFinder;

class ExchangePointHandler implements CommandHandlerInterface
{
    /** @var ClientFinder */
    private $clientFinder;

    /** @var PharmacyFinder */
    private $pharmacyFinder;

    /** @var WriteModelInterface */
    private $writeModel;


    public function __construct(
        ClientFinder $clientFinder,
        PharmacyFinder $pharmacyFinder,
        WriteModelInterface $writeModel
    ) {
        $this->clientFinder   = $clientFinder;
        $this->pharmacyFinder = $pharmacyFinder;
        $this->writeModel     = $writeModel;
    }


    public function __invoke(ExchangePointCommand $command): void
    {
        $client   = $this->clientFinder->findOneOrFailByUuid($command->clientUuid);
        $pharmacy = $this->pharmacyFinder->findOneOrFailByUuid($command->pharmacyUuid);
        $points   = $client->getPoints($command->quantity);

        foreach ($points as $point) {
            $point->exchangePoint($pharmacy, $command->redeemedAt);
            $this->writeModel->loadToStorage($point);
        }

        $this->writeModel->save();
    }
}
