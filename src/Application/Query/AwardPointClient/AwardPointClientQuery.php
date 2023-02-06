<?php

declare(strict_types=1);

namespace App\Application\Query\AwardPointClient;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class AwardPointClientQuery
{
    private UuidInterface $pharmacyUuid;
    private UuidInterface $clientUuid;


    public function __construct(string $pharmacyUuid, string $clientUuid)
    {
        $this->pharmacyUuid = Uuid::fromString($pharmacyUuid);
        $this->clientUuid   = Uuid::fromString($clientUuid);
    }


    public function pharmacyUuid(): UuidInterface
    {
        return $this->pharmacyUuid;
    }


    public function clientUuid(): UuidInterface
    {
        return $this->clientUuid;
    }
}
