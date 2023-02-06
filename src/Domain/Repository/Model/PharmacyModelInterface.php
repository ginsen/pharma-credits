<?php

declare(strict_types=1);

namespace App\Domain\Repository\Model;

use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\Entity\Pharmacy;

interface PharmacyModelInterface
{
    /**
     * @throws
     */
    public function findOneOrNull(SpecificationInterface $specification): ?Pharmacy;
}
