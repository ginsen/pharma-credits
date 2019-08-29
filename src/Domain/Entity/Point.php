<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObj\AwardedAt;
use App\Domain\ValueObj\RedeemedAt;
use Ramsey\Uuid\UuidInterface;

class Point
{
    /** @var UuidInterface */
    protected $uuid;

    /** @var Client */
    protected $client;

    /** @var Pharmacy */
    protected $pharmacyDispensing;

    /** @var Pharmacy */
    protected $pharmacyRedeeming;

    /** @var AwardedAt */
    protected $awardedAt;

    /** @var RedeemedAt */
    protected $redeemedAt;
}
