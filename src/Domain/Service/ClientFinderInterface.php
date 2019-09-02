<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Client;
use Ramsey\Uuid\UuidInterface;

interface ClientFinderInterface
{
    public function findOneOrFailByUuid(UuidInterface $uuid): Client;
}
