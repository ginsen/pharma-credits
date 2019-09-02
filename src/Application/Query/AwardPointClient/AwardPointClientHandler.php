<?php

declare(strict_types=1);

namespace App\Application\Query\AwardPointClient;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Service\ClientFinderInterface;
use App\Domain\Service\PharmacyFinderInterface;
use App\Domain\Service\PointCountFinderInterface;

class AwardPointClientHandler implements QueryHandlerInterface
{
    /** @var PharmacyFinderInterface */
    private $pharmacyFinder;

    /** @var ClientFinderInterface */
    private $clientFinder;

    /** @var PointCountFinderInterface */
    private $pointCountFinder;


    public function __construct(
        PharmacyFinderInterface $pharmacyFinder,
        ClientFinderInterface $clientFinder,
        PointCountFinderInterface $pointCountFinder
    ) {
        $this->pharmacyFinder   = $pharmacyFinder;
        $this->clientFinder     = $clientFinder;
        $this->pointCountFinder = $pointCountFinder;
    }


    /**
     * @param AwardPointClientQuery $command
     * @return int
     */
    public function __invoke(AwardPointClientQuery $command): int
    {
        $pharmacy = $this->pharmacyFinder->findOneOrFailByUuid($command->pharmacyUuid);
        $client   = $this->clientFinder->findOneOrFailByUuid($command->clientUuid);

        return $this->pointCountFinder->countAwardPointsClient($pharmacy, $client);
    }
}
