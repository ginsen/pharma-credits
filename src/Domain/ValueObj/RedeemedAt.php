<?php

declare(strict_types=1);

namespace App\Domain\ValueObj;

final class RedeemedAt
{
    const FORMAT = 'Y-m-d\TH:i:s.uP';

    use TraitDateTime;
}
