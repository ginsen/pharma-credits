<?php

declare(strict_types=1);

namespace App\Infrastructure\Specification\ORM;

use App\Domain\Entity\Pharmacy;
use App\Domain\Entity\Point;
use App\Infrastructure\Specification\Common\ORM\OrmSpecification;
use Doctrine\ORM\Query\Expr;

class PointWithPharmacyAwarding extends OrmSpecification
{
    public function __construct(Expr $expr, Pharmacy $pharmacy)
    {
        $this->setParameter('pharmacy', $pharmacy);

        parent::__construct($expr);
    }


    public function getConditions(): Expr\Comparison
    {
        return $this->expr->eq(Point::ALIAS . '.pharmacyAwarding', ':pharmacy');
    }
}
