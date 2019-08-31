<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\Entity\Point;
use App\Domain\Repository\PointReadModelInterface;
use App\Infrastructure\Doctrine\Model\ReadModel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

class PointReadModel extends ReadModel implements PointReadModelInterface
{
    const ENTITY_ALIAS = 'point';


    /**
     * ClientReadModel constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->class = Point::class;
        parent::__construct($entityManager);
    }


    /**
     * @param SpecificationInterface $specification
     * @throws NonUniqueResultException
     * @return int
     */
    public function getCount(SpecificationInterface $specification): int
    {
        return $this->getOrmCount($specification);
    }
}
