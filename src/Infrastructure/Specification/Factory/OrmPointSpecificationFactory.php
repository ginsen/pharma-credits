<?php

declare(strict_types=1);

namespace App\Infrastructure\Specification\Factory;

use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Specification\PointSpecificationFactoryInterface;
use App\Domain\ValueObj\AwardedAt;
use App\Infrastructure\Specification\ORM\PointWithAwardedAtBetweenDates;
use App\Infrastructure\Specification\ORM\PointWithClient;
use App\Infrastructure\Specification\ORM\PointWithoutRedeemed;
use App\Infrastructure\Specification\ORM\PointWithPharmacyAwarding;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr;

class OrmPointSpecificationFactory implements PointSpecificationFactoryInterface
{
    /** @var Expr */
    private $expr;

    /**
     * OrmPharmacySpecificationFactory constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->expr = $entityManager->getExpressionBuilder();
    }


    /**
     * @param Pharmacy  $pharmacy
     * @param AwardedAt $dateIni
     * @param AwardedAt $dateEnd
     * @return SpecificationInterface
     */
    public function createForCountPointsByPharmacyBetweenDates(
        Pharmacy $pharmacy,
        AwardedAt $dateIni,
        AwardedAt $dateEnd
    ): SpecificationInterface {
        $pointWithPharmacy = new PointWithPharmacyAwarding($this->expr, $pharmacy);
        $pointBetweenDates = new PointWithAwardedAtBetweenDates($this->expr, $dateIni, $dateEnd);
        $pointOnlyAwarded  = new PointWithoutRedeemed($this->expr);

        return $pointWithPharmacy
            ->andX($pointBetweenDates)
            ->andX($pointOnlyAwarded);
    }


    /**
     * @param Pharmacy $pharmacy
     * @param Client   $client
     * @return SpecificationInterface
     */
    public function createForCountPointsByPharmacyAndClient(
        Pharmacy $pharmacy,
        Client $client
    ): SpecificationInterface {
        $pointWithPharmacy = new PointWithPharmacyAwarding($this->expr, $pharmacy);
        $pointWithClient   = new PointWithClient($this->expr, $client);

        return $pointWithPharmacy->andX($pointWithClient);
    }
}
