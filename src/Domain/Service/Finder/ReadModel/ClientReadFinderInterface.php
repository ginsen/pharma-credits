<?php

declare(strict_types=1);

namespace App\Domain\Service\Finder\ReadModel;

use App\Domain\Entity\Client;
use Ramsey\Uuid\UuidInterface;

interface ClientReadFinderInterface
{
    public function findOneOrFailByUuid(UuidInterface $uuid): Client;
}
