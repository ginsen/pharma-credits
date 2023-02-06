<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\WriteModel;

use App\Domain\Entity\Client;
use App\Domain\Repository\WriteModel\ClientWriteModelInterface;
use App\Infrastructure\Repository\Common\ClientRepositoryTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ClientWriteModel extends EntityRepository implements ClientWriteModelInterface
{
    public function __construct(EntityManagerInterface $emWriter)
    {
        $class = Client::class;
        parent::__construct($emWriter, $emWriter->getClassMetadata($class));
    }

    use ClientRepositoryTrait;
}
