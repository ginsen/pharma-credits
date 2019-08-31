<?php

declare(strict_types=1);

namespace App\Application\Query\AwardPointClient;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Service\ClientFinder;
use App\Domain\Service\PharmacyFinder;
use App\Domain\Service\PointCountFinder;

class AwardPointClientHandler implements QueryHandlerInterface
{
    /** @var PharmacyFinder */
    private $pharmacyFinder;

    /** @var ClientFinder */
    private $clientFinder;

    /** @var PointCountFinder */
    private $pointCountFinder;


    public function __construct(
        PharmacyFinder $pharmacyFinder,
        ClientFinder $clientFinder,
        PointCountFinder $pointCountFinder
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
