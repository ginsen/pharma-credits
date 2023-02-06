<?php

declare(strict_types=1);

namespace App\Infrastructure\Specification\Factory;

use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\Specification\PharmacySpecificationFactoryInterface;
use App\Infrastructure\Specification\ORM\PharmacyWithUuid;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr;
use Ramsey\Uuid\UuidInterface;

class OrmPharmacySpecificationFactory implements PharmacySpecificationFactoryInterface
{
    private Expr $expr;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->expr = $entityManager->getExpressionBuilder();
    }


    public function createForFindOneWithUuid(UuidInterface $uuid): SpecificationInterface
    {
        return new PharmacyWithUuid($this->expr, $uuid);
    }
}
