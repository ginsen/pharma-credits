<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Repository\PointReadModelInterface;
use App\Domain\Specification\PointSpecificationFactoryInterface;
use App\Domain\ValueObj\AwardedAt;

class PointCountFinder implements PointCountFinderInterface
{
    /** @var PointReadModelInterface */
    private $pointReadModel;

    /** @var PointSpecificationFactoryInterface */
    private $pointSpecFactory;


    public function __construct(
        PointReadModelInterface $pointReadModel,
        PointSpecificationFactoryInterface $pointSpecFactory
    ) {
        $this->pointReadModel   = $pointReadModel;
        $this->pointSpecFactory = $pointSpecFactory;
    }


    /**
     * @param Pharmacy  $pharmacy
     * @param AwardedAt $dateInit
     * @param AwardedAt $dateEnd
     * @return int
     */
    public function countAwardPointsBetweenDates(Pharmacy $pharmacy, AwardedAt $dateInit, AwardedAt $dateEnd): int
    {
        $specification = $this->pointSpecFactory->createForCountPointsByPharmacyBetweenDates(
            $pharmacy,
            $dateInit,
            $dateEnd
        );

        return $this->pointReadModel->getCount($specification);
    }


    /**
     * @param Pharmacy $pharmacy
     * @param Client   $client
     * @return int
     */
    public function countAwardPointsClient(Pharmacy $pharmacy, Client $client): int
    {
        $specification = $this->pointSpecFactory->createForCountPointsByPharmacyAndClient($pharmacy, $client);

        return $this->pointReadModel->getCount($specification);
    }
}
