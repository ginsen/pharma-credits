<?php

declare(strict_types=1);

namespace App\Infrastructure\Specification\ORM;

use App\Infrastructure\Repository\PointReadModel;
use App\Infrastructure\Specification\Common\ORM\OrmSpecification;
use Doctrine\ORM\Query\Expr;

class PointWithoutRedeemed extends OrmSpecification
{
    public function __construct(Expr $expr)
    {
        parent::__construct($expr);
    }


    public function getConditions()
    {
        return $this->expr->isNull(PointReadModel::ENTITY_ALIAS . '.redeemedAt');
    }
}
