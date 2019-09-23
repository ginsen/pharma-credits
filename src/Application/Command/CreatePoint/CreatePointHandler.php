<?php

declare(strict_types=1);

namespace App\Application\Command\CreatePoint;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\Entity\Point;
use App\Domain\Service\ClientFinderInterface;
use App\Domain\Service\PharmacyFinderInterface;

class CreatePointHandler implements CommandHandlerInterface
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


    /**
     * @param CreatePointCommand $command
     * @throws \Exception
     */
    public function __invoke(CreatePointCommand $command): void
    {
        $client   = $this->clientFinder->findOneOrFailByUuid($command->clientUuid);
        $pharmacy = $this->pharmacyFinder->findOneOrFailByUuid($command->pharmacyUuid);

        for ($i=0; $command->quantity->toNumber() > $i; ++$i) {
            Point::createAwardPoint($client, $pharmacy, $command->awardedAt);
        }
    }
}
