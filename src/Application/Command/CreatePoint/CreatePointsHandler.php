<?php

declare(strict_types=1);

namespace App\Application\Command\CreatePoint;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\Common\WriteModel\WriteModelInterface;
use App\Domain\Entity\Point;
use App\Domain\Service\ClientFinderInterface;
use App\Domain\Service\PharmacyFinderInterface;

class CreatePointsHandler implements CommandHandlerInterface
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


    /**
     * @param CreatePointsCommand $command
     * @throws \Exception
     */
    public function __invoke(CreatePointsCommand $command): void
    {
        $client   = $this->clientFinder->findOneOrFailByUuid($command->clientUuid);
        $pharmacy = $this->pharmacyFinder->findOneOrFailByUuid($command->pharmacyUuid);

        for ($i=0; $command->quantity->toNumber() > $i; ++$i) {
            $point = Point::createAwardPoint($client, $pharmacy, $command->awardedAt);
            $this->writeModel->queueToPersist($point);
        }

        $this->writeModel->persist();
    }
}
