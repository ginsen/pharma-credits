<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Common;

use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\Entity\Pharmacy;
use Doctrine\ORM\Query;

trait PharmacyRepositoryTrait
{
    public function findOneOrNull(SpecificationInterface $specification): ?Pharmacy
    {
        $query = $this->getOrmQuery($specification);

        return $query->getOneOrNullResult();
    }


    protected function getOrmQuery(SpecificationInterface $spec): Query
    {
        $builder = $this->createQueryBuilder(Pharmacy::ALIAS);

        $builder
            ->select(Pharmacy::ALIAS)
            ->where($spec->getConditions())
            ->setParameters($spec->getParameters());

        return $builder->getQuery();
    }
}
