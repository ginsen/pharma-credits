<?php

declare(strict_types=1);

namespace App\Domain\Specification;

use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\ValueObj\AwardedAt;

interface PointSpecificationFactoryInterface
{
    public function createForCountPointsByPharmacyBetweenDates(
        Pharmacy $pharmacy,
        AwardedAt $dateIni,
        AwardedAt $dateEnd
    ): SpecificationInterface;

    public function createForCountPointsByPharmacyAndClient(
        Pharmacy $pharmacy,
        Client $client
    ): SpecificationInterface;
}