<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\ReadModel;

use App\Domain\Entity\Client;
use App\Domain\Repository\ReadModel\ClientReadModelInterface;
use App\Infrastructure\Repository\Common\ClientRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ClientReadModel extends ServiceEntityRepository implements ClientReadModelInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    use ClientRepositoryTrait;
}
