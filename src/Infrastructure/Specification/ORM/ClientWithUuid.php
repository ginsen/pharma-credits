<?php

declare(strict_types=1);

namespace App\Infrastructure\Specification\ORM;

use App\Domain\Entity\Client;
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


    public function getConditions(): Expr\Comparison
    {
        return $this->expr->eq(Client::ALIAS . '.uuid', ':uuid');
    }
}
