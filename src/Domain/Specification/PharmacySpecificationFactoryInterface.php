<?php

declare(strict_types=1);

namespace App\Domain\Specification;

use App\Domain\Common\Specification\SpecificationInterface;
use Ramsey\Uuid\UuidInterface;

interface PharmacySpecificationFactoryInterface
{
    public function createForFindOneWithUuid(UuidInterface $uuid): SpecificationInterface;
}
