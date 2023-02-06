<?php

declare(strict_types=1);

namespace App\Domain\Service\Finder\WriteModel;

use App\Domain\Entity\Client;
use App\Domain\Exception\ClientException;
use App\Domain\Repository\WriteModel\ClientWriteModelInterface;
use App\Domain\Specification\ClientSpecificationFactoryInterface;
use Ramsey\Uuid\UuidInterface;

class ClientWriteFinder implements ClientWriteFinderInterface
{
    public function __construct(
        private readonly ClientWriteModelInterface $writeModel,
        private readonly ClientSpecificationFactoryInterface $specFactory
    ) {
    }


    public function findOneOrFailByUuid(UuidInterface $uuid): Client
    {
        $specification = $this->specFactory->createForFindOneWithUuid($uuid);

        if (!$client = $this->writeModel->findOneOrNull($specification)) {
            throw new ClientException('Client not found');
        }

        return $client;
    }
}
