<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\WriteModel;

use App\Domain\Entity\Pharmacy;
use App\Domain\Repository\WriteModel\PharmacyWriteModelInterface;
use App\Infrastructure\Repository\Common\PharmacyRepositoryTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class PharmacyWriteModel extends EntityRepository implements PharmacyWriteModelInterface
{
    public function __construct(EntityManagerInterface $emWriter)
    {
        $class = Pharmacy::class;
        parent::__construct($emWriter, $emWriter->getClassMetadata($class));
    }

    use PharmacyRepositoryTrait;
}
