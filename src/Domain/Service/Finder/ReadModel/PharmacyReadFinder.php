<?php

declare(strict_types=1);

namespace App\Domain\Service\Finder\ReadModel;

use App\Domain\Entity\Pharmacy;
use App\Domain\Exception\PharmacyException;
use App\Domain\Repository\ReadModel\PharmacyReadModelInterface;
use App\Domain\Specification\PharmacySpecificationFactoryInterface;
use Ramsey\Uuid\UuidInterface;

class PharmacyReadFinder implements PharmacyReadFinderInterface
{
    public function __construct(
        private readonly PharmacyReadModelInterface $readModel,
        private readonly PharmacySpecificationFactoryInterface $specFactory
    ) {
    }


    public function findOneOrFailByUuid(UuidInterface $uuid): Pharmacy
    {
        $specification = $this->specFactory->createForFindOneWithUuid($uuid);
        $pharmacy      = $this->readModel->findOneOrNull($specification);

        if (empty($pharmacy)) {
            throw new PharmacyException('Pharmacy not found');
        }

        return $pharmacy;
    }
}
