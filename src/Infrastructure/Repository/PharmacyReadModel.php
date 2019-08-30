<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\Entity\Pharmacy;
use App\Domain\Repository\PharmacyReadModelInterface;
use App\Infrastructure\Doctrine\Model\ReadModel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

class PharmacyReadModel extends ReadModel implements PharmacyReadModelInterface
{
    const ENTITY_ALIAS = 'pharmacy';


    /**
     * PharmacyReadModel constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->class = Pharmacy::class;
        parent::__construct($entityManager);
    }


    /**
     * @param SpecificationInterface $specification
     * @return Pharmacy|null
     * @throws NonUniqueResultException
     */
    public function getOneOrNull(SpecificationInterface $specification): ?Pharmacy
    {
        $query = $this->getOrmQuery($specification);

        return $query->getOneOrNullResult();
    }
}
