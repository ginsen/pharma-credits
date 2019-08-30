<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Common\Specification\SpecificationInterface;

interface PointReadModelInterface
{
    public function getCount(SpecificationInterface $specification): int;
}