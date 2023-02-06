<?php

declare(strict_types=1);

namespace App\Infrastructure\Specification\ORM;

use App\Domain\Entity\Pharmacy;
use App\Infrastructure\Specification\Common\ORM\OrmSpecification;
use Doctrine\ORM\Query\Expr;
use Ramsey\Uuid\UuidInterface;

class PharmacyWithUuid extends OrmSpecification
{
    public function __construct(Expr $expr, UuidInterface $uuid)
    {
        $this->setParameter('uuid', $uuid);

        parent::__construct($expr);
    }


    public function getConditions(): Expr\Comparison
    {
        return $this->expr->eq(Pharmacy::ALIAS . '.uuid', ':uuid');
    }
}
