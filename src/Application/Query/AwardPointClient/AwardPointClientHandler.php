<?php

declare(strict_types=1);

namespace App\Application\Query\AwardPointClient;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Repository\PointReadModelInterface;
use App\Domain\Service\ClientFinder;
use App\Domain\Service\PharmacyFinder;
use App\Domain\Specification\PointSpecificationFactoryInterface;

class AwardPointClientHandler implements QueryHandlerInterface
{
    /** @var PharmacyFinder */
    private $pharmacyFinder;

    // @var ClientFinder
    private $clientFinder;

    /** @var PointReadModelInterface */
    private $pointReadModel;

    /** @var PointSpecificationFactoryInterface */
    private $pointSpecFactory;


    public function __construct(
        PharmacyFinder $pharmacyFinder,
        ClientFinder $clientFinder,
        PointReadModelInterface $pointReadModel,
        PointSpecificationFactoryInterface $pointSpecFactory
    ) {
        $this->pharmacyFinder   = $pharmacyFinder;
        $this->clientFinder     = $clientFinder;
        $this->pointReadModel   = $pointReadModel;
        $this->pointSpecFactory = $pointSpecFactory;
    }


    /**
     * @param AwardPointClientQuery $command
     * @return int
     */
    public function __invoke(AwardPointClientQuery $command): int
    {
        $pharmacy = $this->pharmacyFinder->findOneOrFailByUuid($command->pharmacyUuid);
        $client   = $this->clientFinder->findOneOrFailByUuid($command->clientUuid);

        $specification = $this->pointSpecFactory->createForCountPointsByPharmacyAndClient($pharmacy, $client);

        return $this->pointReadModel->getCount($specification);
    }
}
