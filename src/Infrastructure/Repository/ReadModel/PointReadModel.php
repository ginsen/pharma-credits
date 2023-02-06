<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\ReadModel;

use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\Entity\Point;
use App\Domain\Repository\ReadModel\PointReadModelInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PointReadModel extends ServiceEntityRepository implements PointReadModelInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Point::class);
    }


    public function getCount(SpecificationInterface $specification): int
    {
        $builder = $this->createQueryBuilder(Point::ALIAS);

        $builder
            ->select(sprintf('count(%s.uuid)', Point::ALIAS))
            ->where($specification->getConditions())
            ->setParameters($specification->getParameters());

        return (int) $builder->getQuery()->getSingleScalarResult();
    }
}
