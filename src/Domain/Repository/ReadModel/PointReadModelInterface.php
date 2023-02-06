<?php

declare(strict_types=1);

namespace App\Domain\Repository\ReadModel;

use App\Domain\Common\Specification\SpecificationInterface;

interface PointReadModelInterface
{
    /**
     * @throws
     */
    public function getCount(SpecificationInterface $specification): int;
}
