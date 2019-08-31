<?php

declare(strict_types=1);

namespace App\Application\Query\AwardPointDates;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Repository\PointReadModelInterface;
use App\Domain\Service\PharmacyFinder;
use App\Domain\Specification\PointSpecificationFactoryInterface;

class AwardPointDatesHandler implements QueryHandlerInterface
{
    // @var PharmacyFinder
    private $pharmacyFinder;

    /** @var PointReadModelInterface */
    private $pointReadModel;

    /** @var PointSpecificationFactoryInterface */
    private $pointSpecFactory;


    public function __construct(
        PharmacyFinder $pharmacyFinder,
        PointReadModelInterface $pointReadModel,
        PointSpecificationFactoryInterface $pointSpecFactory
    ) {
        $this->pharmacyFinder   = $pharmacyFinder;
        $this->pointReadModel   = $pointReadModel;
        $this->pointSpecFactory = $pointSpecFactory;
    }


    /**
     * @param AwardPointDatesQuery $command
     * @return int
     */
    public function __invoke(AwardPointDatesQuery $command): int
    {
        $pharmacy      = $this->pharmacyFinder->findOneOrFailByUuid($command->pharmacyUuid);
        $specification = $this->pointSpecFactory->createForCountPointsByPharmacyBetweenDates(
            $pharmacy,
            $command->dateInit,
            $command->dateEnd
        );

        return $this->pointReadModel->getCount($specification);
    }
}
