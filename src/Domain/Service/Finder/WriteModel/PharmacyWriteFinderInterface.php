<?php

declare(strict_types=1);

namespace App\Domain\Service\Finder\WriteModel;

use App\Domain\Entity\Pharmacy;
use Ramsey\Uuid\UuidInterface;

interface PharmacyWriteFinderInterface
{
    public function findOneOrFailByUuid(UuidInterface $uuid): Pharmacy;
}
