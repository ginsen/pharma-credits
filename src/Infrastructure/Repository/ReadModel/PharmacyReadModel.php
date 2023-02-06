<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\ReadModel;

use App\Domain\Entity\Pharmacy;
use App\Domain\Repository\ReadModel\PharmacyReadModelInterface;
use App\Infrastructure\Repository\Common\PharmacyRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PharmacyReadModel extends ServiceEntityRepository implements PharmacyReadModelInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pharmacy::class);
    }

    use PharmacyRepositoryTrait;
}
