<?php

declare(strict_types=1);

namespace App\Application\Query\AwardPointDates;

use App\Domain\ValueObj\AwardedAt;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class AwardPointDatesQuery
{
    /** @var UuidInterface */
    public $pharmacyUuid;

    /** @var AwardedAt */
    public $dateInit;

    /** @var AwardedAt */
    public $dateEnd;


    public function __construct(string $uuid, string $dateInit, string $dateEnd)
    {
        $this->pharmacyUuid = Uuid::fromString($uuid);
        $this->dateInit     = AwardedAt::fromStr($dateInit);
        $this->dateEnd      = AwardedAt::fromStr($dateEnd);
    }
}
