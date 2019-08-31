<?php

declare(strict_types=1);

namespace App\Application\Query\AwardPointDates;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Service\PharmacyFinder;
use App\Domain\Service\PointCountFinder;

class AwardPointDatesHandler implements QueryHandlerInterface
{
    /** @var PharmacyFinder */
    private $pharmacyFinder;

    /** @var PointCountFinder */
    private $pointCountFinder;


    public function __construct(PharmacyFinder $pharmacyFinder, PointCountFinder $pointCountFinder)
    {
        $this->pharmacyFinder   = $pharmacyFinder;
        $this->pointCountFinder = $pointCountFinder;
    }


    /**
     * @param AwardPointDatesQuery $command
     * @return int
     */
    public function __invoke(AwardPointDatesQuery $command): int
    {
        $pharmacy = $this->pharmacyFinder->findOneOrFailByUuid($command->pharmacyUuid);

        return $this->pointCountFinder->countAwardPointsBetweenDates(
            $pharmacy,
            $command->dateInit,
            $command->dateEnd
        );
    }
}
