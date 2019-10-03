<?php

declare(strict_types=1);

namespace App\Infrastructure\Specification\ORM;

use App\Infrastructure\Repository\PointReadModel;
use App\Infrastructure\Specification\Common\ORM\OrmSpecification;

class PointWithoutRedeemed extends OrmSpecification
{
    public function getConditions()
    {
        return $this->expr->isNull(PointReadModel::ENTITY_ALIAS . '.redeemedAt');
    }
}
