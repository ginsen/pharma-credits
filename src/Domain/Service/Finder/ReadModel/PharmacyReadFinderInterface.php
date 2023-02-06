<?php

declare(strict_types=1);

namespace App\Domain\Service\Finder\ReadModel;

use App\Domain\Entity\Pharmacy;
use Ramsey\Uuid\UuidInterface;

interface PharmacyReadFinderInterface
{
    public function findOneOrFailByUuid(UuidInterface $uuid): Pharmacy;
}
