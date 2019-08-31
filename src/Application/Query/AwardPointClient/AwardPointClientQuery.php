<?php

declare(strict_types=1);

namespace App\Application\Query\AwardPointClient;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class AwardPointClientQuery
{
    /** @var UuidInterface */
    public $pharmacyUuid;

    /** @var UuidInterface */
    public $clientUuid;


    public function __construct(string $pharmacyUuid, string $clientUuid)
    {
        $this->pharmacyUuid = Uuid::fromString($pharmacyUuid);
        $this->clientUuid   = Uuid::fromString($clientUuid);
    }
}
