<?php

declare(strict_types=1);

namespace App\Domain\ValueObj;

final class PharmacyName
{
    public const MAX_LENGTH = 80;

    use TraitName;
}
