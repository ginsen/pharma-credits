<?php

declare(strict_types=1);

namespace App\Infrastructure\Specification\ORM;

use App\Domain\Entity\Point;
use App\Domain\ValueObj\AwardedAt;
use App\Infrastructure\Specification\Common\ORM\OrmSpecification;
use Doctrine\ORM\Query\Expr;

class PointWithAwardedAtBetweenDates extends OrmSpecification
{
    public function __construct(Expr $expr, AwardedAt $dateInit, AwardedAt $dateEnd)
    {
        $this->setParameter('dateInit', $dateInit);
        $this->setParameter('dateEnd', $dateEnd);

        parent::__construct($expr);
    }


    public function getConditions(): string
    {
        return $this->expr->between(Point::ALIAS . '.awardedAt', ':dateInit', ':dateEnd');
    }
}
