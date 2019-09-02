<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Pharmacy;
use Ramsey\Uuid\UuidInterface;

interface PharmacyFinderInterface
{
    public function findOneOrFailByUuid(UuidInterface $uuid): Pharmacy;
}
