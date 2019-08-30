<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\Entity\Pharmacy;

interface PharmacyReadModelInterface
{
    public function getOneOrNull(SpecificationInterface $specification): ?Pharmacy;
}
