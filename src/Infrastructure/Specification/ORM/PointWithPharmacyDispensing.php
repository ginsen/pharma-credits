<?php

declare(strict_types=1);

namespace App\Infrastructure\Specification\ORM;

use App\Domain\Entity\Pharmacy;
use App\Infrastructure\Repository\PointReadModel;
use App\Infrastructure\Specification\Common\ORM\OrmSpecification;
use Doctrine\ORM\Query\Expr;

class PointWithPharmacyDispensing extends OrmSpecification
{
    public function __construct(Expr $expr, Pharmacy $pharmacy)
    {
        $this->setParameter('pharmacy', $pharmacy);

        parent::__construct($expr);
    }


    public function getConditions()
    {
        return $this->expr->eq(PointReadModel::ENTITY_ALIAS . '.pharmacyDispensing', ':pharmacy');
    }
}