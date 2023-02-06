<?php

declare(strict_types=1);

namespace App\Application\Query\AwardPointDates;

use App\Domain\Service\Finder\ReadModel\PharmacyReadFinderInterface;
use App\Domain\Service\Finder\ReadModel\PointReadFinderInterface;

class AwardPointDatesQueryHandler
{
    public function __construct(
        private readonly PharmacyReadFinderInterface $pharmacyFinder,
        private readonly PointReadFinderInterface $pointCountFinder
    ) {
    }


    public function __invoke(AwardPointDatesQuery $command): int
    {
        $pharmacy = $this->pharmacyFinder->findOneOrFailByUuid($command->pharmacyUuid());

        return $this->pointCountFinder->countAwardPointsBetweenDates(
            $pharmacy,
            $command->dateInit(),
            $command->dateEnd()
        );
    }
}
