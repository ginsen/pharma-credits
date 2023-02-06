<?php

declare(strict_types=1);

namespace App\Infrastructure\Specification\ORM;

use App\Domain\Entity\Point;
use App\Infrastructure\Specification\Common\ORM\OrmSpecification;

class PointWithoutRedeemed extends OrmSpecification
{
    public function getConditions(): string
    {
        return $this->expr->isNull(Point::ALIAS . '.redeemedAt');
    }
}
