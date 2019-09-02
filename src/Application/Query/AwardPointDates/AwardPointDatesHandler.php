<?php

declare(strict_types=1);

namespace App\Application\Query\AwardPointDates;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Service\PharmacyFinderInterface;
use App\Domain\Service\PointCountFinderInterface;

class AwardPointDatesHandler implements QueryHandlerInterface
{
    /** @var PharmacyFinderInterface */
    private $pharmacyFinder;

    /** @var PointCountFinderInterface */
    private $pointCountFinder;


    public function __construct(PharmacyFinderInterface $pharmacyFinder, PointCountFinderInterface $pointCountFinder)
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
