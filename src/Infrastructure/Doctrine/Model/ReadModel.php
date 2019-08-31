<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Model;

use App\Domain\Common\Specification\SpecificationInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder as OrmQueryBuilder;

abstract class ReadModel
{
    const ENTITY_ALIAS = 'entity';

    /** @var string */
    protected $class;

    /** @var EntityManagerInterface */
    private $entityManager;


    /**
     * MySqlRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->entityManager->getRepository($this->class);
    }


    /**
     * @param  SpecificationInterface $specification
     * @return Query
     */
    protected function getOrmQuery(SpecificationInterface $specification): Query
    {
        $builder = $this->createOrmQueryBuilder();

        $builder
            ->select(static::ENTITY_ALIAS)
            ->from($this->class, static::ENTITY_ALIAS)
            ->where($specification->getConditions())
            ->setParameters($specification->getParameters());

        return $builder->getQuery();
    }


    /**
     * @param SpecificationInterface $specification
     * @throws NonUniqueResultException
     * @return int
     */
    protected function getOrmCount(SpecificationInterface $specification): int
    {
        $builder = $this->createOrmQueryBuilder();

        $builder
            ->select(sprintf('count(%s.uuid)', static::ENTITY_ALIAS))
            ->from($this->class, static::ENTITY_ALIAS)
            ->where($specification->getConditions())
            ->setParameters($specification->getParameters());

        return (int) $builder->getQuery()->getSingleScalarResult();
    }


    /**
     * @return OrmQueryBuilder
     */
    protected function createOrmQueryBuilder(): OrmQueryBuilder
    {
        return $this->entityManager->createQueryBuilder();
    }
}
