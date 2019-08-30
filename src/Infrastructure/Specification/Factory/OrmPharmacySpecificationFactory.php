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
    /** @var Expr */
    private $expr;


    /**
     * OrmPharmacySpecificationFactory constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->expr = $entityManager->getExpressionBuilder();
    }


    /**
     * @param UuidInterface $uuid
     * @return SpecificationInterface
     */
    public function createForFindOneWithUuid(UuidInterface $uuid): SpecificationInterface
    {
        return new PharmacyWithUuid($this->expr, $uuid);
    }
}
