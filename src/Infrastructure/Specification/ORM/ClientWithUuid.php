<?php

declare(strict_types=1);

namespace App\Infrastructure\Specification\ORM;

use App\Infrastructure\Repository\ClientReadModel;
use App\Infrastructure\Specification\Common\ORM\OrmSpecification;
use Doctrine\ORM\Query\Expr;
use Ramsey\Uuid\UuidInterface;

class ClientWithUuid extends OrmSpecification
{
    public function __construct(Expr $expr, UuidInterface $uuid)
    {
        $this->setParameter('uuid', $uuid);

        parent::__construct($expr);
    }


    public function getConditions()
    {
        return $this->expr->eq(ClientReadModel::ENTITY_ALIAS .'.uuid', ':uuid');
    }
}
