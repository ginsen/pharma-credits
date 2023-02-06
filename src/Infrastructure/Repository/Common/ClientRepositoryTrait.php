<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Common;

use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\Entity\Client;
use Doctrine\ORM\Query;

trait ClientRepositoryTrait
{
    public function findOneOrNull(SpecificationInterface $specification): ?Client
    {
        $query = $this->getOrmQuery($specification);

        return $query->getOneOrNullResult();
    }


    protected function getOrmQuery(SpecificationInterface $spec): Query
    {
        $builder = $this->createQueryBuilder(Client::ALIAS);

        $builder
            ->select(Client::ALIAS)
            ->where($spec->getConditions())
            ->setParameters($spec->getParameters());

        return $builder->getQuery();
    }
}
