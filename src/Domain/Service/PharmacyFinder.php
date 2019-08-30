<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Pharmacy;
use App\Domain\Exception\PharmacyException;
use App\Domain\Repository\PharmacyReadModelInterface;
use App\Domain\Specification\PharmacySpecificationFactoryInterface;
use Ramsey\Uuid\UuidInterface;

class PharmacyFinder
{
    /** @var PharmacyReadModelInterface  */
    private $readModel;

    /** @var PharmacySpecificationFactoryInterface */
    private $specFactory;


    public function __construct(
        PharmacyReadModelInterface $readModel,
        PharmacySpecificationFactoryInterface $specFactory
    ) {
        $this->readModel   = $readModel;
        $this->specFactory = $specFactory;
    }


    public function findOneOrFailByUuid(UuidInterface $uuid): Pharmacy
    {
        $specification = $this->specFactory->createForFindOneWithUuid($uuid);
        $pharmacy      = $this->readModel->getOneOrNull($specification);

        if (empty($pharmacy)) {
            throw new PharmacyException('Pharmacy not found');
        }

        return $pharmacy;
    }
}
