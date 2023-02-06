<?php

declare(strict_types=1);

namespace App\Application\Query\AwardPointClient;

use App\Domain\Service\Finder\ReadModel\ClientReadFinderInterface;
use App\Domain\Service\Finder\ReadModel\PharmacyReadFinderInterface;
use App\Domain\Service\Finder\ReadModel\PointReadFinderInterface;

class AwardPointClientQueryHandler
{
    public function __construct(
        private readonly PharmacyReadFinderInterface $pharmacyFinder,
        private readonly ClientReadFinderInterface $clientFinder,
        private readonly PointReadFinderInterface $pointCountFinder
    ) {
    }


    public function __invoke(AwardPointClientQuery $command): int
    {
        $pharmacy = $this->pharmacyFinder->findOneOrFailByUuid($command->pharmacyUuid());
        $client   = $this->clientFinder->findOneOrFailByUuid($command->clientUuid());

        return $this->pointCountFinder->countAwardPointsClient($pharmacy, $client);
    }
}
