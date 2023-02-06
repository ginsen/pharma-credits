<?php

declare(strict_types=1);

namespace App\Application\Query\ClientBalance;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ClientBalanceQuery
{
    private UuidInterface $clientUuid;


    public function __construct(string $uuid)
    {
        $this->clientUuid = Uuid::fromString($uuid);
    }


    public function clientUuid(): UuidInterface
    {
        return $this->clientUuid;
    }
}
