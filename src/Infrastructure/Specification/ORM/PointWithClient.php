<?php

declare(strict_types=1);

namespace App\Infrastructure\Specification\ORM;

use App\Domain\Entity\Client;
use App\Infrastructure\Repository\PointReadModel;
use App\Infrastructure\Specification\Common\ORM\OrmSpecification;
use Doctrine\ORM\Query\Expr;

class PointWithClient extends OrmSpecification
{
    public function __construct(Expr $expr, Client $client)
    {
        $this->setParameter('client', $client);

        parent::__construct($expr);
    }


    public function getConditions()
    {
        return $this->expr->eq(PointReadModel::ENTITY_ALIAS . '.client', ':client');
    }
}