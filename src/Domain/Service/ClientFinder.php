<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Client;
use App\Domain\Exception\ClientException;
use App\Domain\Repository\ClientReadModelInterface;
use App\Domain\Specification\ClientSpecificationFactoryInterface;
use Ramsey\Uuid\UuidInterface;

class ClientFinder implements ClientFinderInterface
{
    /** @var ClientReadModelInterface */
    private $readModel;

    /** @var ClientSpecificationFactoryInterface */
    private $specFactory;


    public function __construct(ClientReadModelInterface $readModel, ClientSpecificationFactoryInterface $specFactory)
    {
        $this->readModel   = $readModel;
        $this->specFactory = $specFactory;
    }


    public function findOneOrFailByUuid(UuidInterface $uuid): Client
    {
        $specification = $this->specFactory->createForFindOneWithUuid($uuid);
        $client        = $this->readModel->getOneOrNull($specification);

        if (empty($client)) {
            throw new ClientException('Client not found');
        }

        return $client;
    }
}
