<?php

declare(strict_types=1);

namespace App\Domain\Service\Finder\WriteModel;

use App\Domain\Entity\Client;
use Ramsey\Uuid\UuidInterface;

interface ClientWriteFinderInterface
{
    public function findOneOrFailByUuid(UuidInterface $uuid): Client;
}
