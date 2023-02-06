<?php

declare(strict_types=1);

namespace App\Domain\Service\Finder\WriteModel;

use App\Domain\Entity\Pharmacy;
use App\Domain\Exception\PharmacyException;
use App\Domain\Repository\WriteModel\PharmacyWriteModelInterface;
use App\Domain\Specification\PharmacySpecificationFactoryInterface;
use Ramsey\Uuid\UuidInterface;

class PharmacyWriteFinder implements PharmacyWriteFinderInterface
{
    public function __construct(
        private readonly PharmacyWriteModelInterface $writeModel,
        private readonly PharmacySpecificationFactoryInterface $specFactory
    ) {
    }


    public function findOneOrFailByUuid(UuidInterface $uuid): Pharmacy
    {
        $specification = $this->specFactory->createForFindOneWithUuid($uuid);
        $pharmacy      = $this->writeModel->findOneOrNull($specification);

        if (empty($pharmacy)) {
            throw new PharmacyException('Pharmacy not found');
        }

        return $pharmacy;
    }
}
