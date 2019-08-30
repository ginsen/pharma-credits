<?php

declare(strict_types=1);

namespace App\Domain\Specification;

use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\ValueObj\DateTime;
use Ramsey\Uuid\UuidInterface;

interface PointSpecificationFactoryInterface
{
    public function createForCountPointsByPharmacyBetweenDates(
        UuidInterface $pharmacyUuid,
        DateTime $dateIni,
        DateTime $dateEnd
    ): SpecificationInterface;
}