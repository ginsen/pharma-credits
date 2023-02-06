<?php

declare(strict_types=1);

namespace App\Domain\ValueObj;

final class ClientName
{
    public const MAX_LENGTH = 60;

    use TraitName;
}
