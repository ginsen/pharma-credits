<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\Entity\Client;
use App\Domain\Repository\ClientReadModelInterface;
use App\Infrastructure\Doctrine\Model\ReadModel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

class ClientReadModel extends ReadModel implements ClientReadModelInterface
{
    const ENTITY_ALIAS = 'client';


    /**
     * ClientReadModel constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->class = Client::class;
        parent::__construct($entityManager);
    }


    /**
     * @param SpecificationInterface $specification
     * @throws NonUniqueResultException
     * @return Client|null
     */
    public function getOneOrNull(SpecificationInterface $specification): ?Client
    {
        $query = $this->getOrmQuery($specification);

        return $query->getOneOrNullResult();
    }
}
