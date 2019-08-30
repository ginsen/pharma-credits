<?php

declare(strict_types=1);

namespace App\Application\Query\ClientBalance;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ClientBalanceQuery
{
    /** @var UuidInterface */
    public $clientUuid;


    public function __construct(string $uuid)
    {
        $this->clientUuid = Uuid::fromString($uuid);
    }
}
