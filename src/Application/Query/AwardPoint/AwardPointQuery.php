<?php

declare(strict_types=1);

namespace App\Application\Query\AwardPoint;

use App\Domain\ValueObj\DateTime;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class AwardPointQuery
{
    /** @var UuidInterface */
    public $pharmacyUuid;

    /** @var DateTime */
    public $dateIni;

    /** @var DateTime */
    public $dateEnd;


    public function __construct(string $uuid, string $dateIni, string $dateEnd)
    {
        $this->pharmacyUuid = Uuid::fromString($uuid);
        $this->dateIni      = DateTime::fromStr($dateIni);
        $this->dateEnd      = DateTime::fromStr($dateEnd);
    }
}
