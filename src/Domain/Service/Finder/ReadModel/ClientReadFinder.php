<?php

declare(strict_types=1);

namespace App\Domain\Service\Finder\ReadModel;

use App\Domain\Entity\Client;
use App\Domain\Exception\ClientException;
use App\Domain\Repository\ReadModel\ClientReadModelInterface;
use App\Domain\Specification\ClientSpecificationFactoryInterface;
use Ramsey\Uuid\UuidInterface;

class ClientReadFinder implements ClientReadFinderInterface
{
    public function __construct(
        private readonly ClientReadModelInterface $readModel,
        private readonly ClientSpecificationFactoryInterface $specFactory
    ) {
    }


    public function findOneOrFailByUuid(UuidInterface $uuid): Client
    {
        $specification = $this->specFactory->createForFindOneWithUuid($uuid);

        if (!$client = $this->readModel->findOneOrNull($specification)) {
            throw new ClientException('Client not found');
        }

        return $client;
    }
}
