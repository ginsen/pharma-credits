<?php

declare(strict_types=1);

namespace App\Infrastructure\Specification\Factory;

use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\Specification\ClientSpecificationFactoryInterface;
use App\Infrastructure\Specification\ORM\ClientWithUuid;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr;
use Ramsey\Uuid\UuidInterface;

class OrmClientSpecificationFactory implements ClientSpecificationFactoryInterface
{
    private Expr $expr;


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
        return new ClientWithUuid($this->expr, $uuid);
    }
}
