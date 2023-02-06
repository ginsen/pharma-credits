<?php

declare(strict_types=1);

namespace App\Domain\Service\Finder\ReadModel;

use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Repository\ReadModel\PointReadModelInterface;
use App\Domain\Specification\PointSpecificationFactoryInterface;
use App\Domain\ValueObj\AwardedAt;

class PointReadFinder implements PointReadFinderInterface
{
    public function __construct(
        private readonly PointReadModelInterface $pointReadModel,
        private readonly PointSpecificationFactoryInterface $pointSpecFactory
    ) {
    }


    public function countAwardPointsBetweenDates(Pharmacy $pharmacy, AwardedAt $dateInit, AwardedAt $dateEnd): int
    {
        $specification = $this->pointSpecFactory->createForCountPointsByPharmacyBetweenDates(
            $pharmacy,
            $dateInit,
            $dateEnd
        );

        return $this->pointReadModel->getCount($specification);
    }


    public function countAwardPointsClient(Pharmacy $pharmacy, Client $client): int
    {
        $specification = $this->pointSpecFactory->createForCountPointsByPharmacyAndClient($pharmacy, $client);

        return $this->pointReadModel->getCount($specification);
    }
}
