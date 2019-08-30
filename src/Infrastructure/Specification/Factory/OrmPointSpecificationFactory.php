<?php


namespace App\Infrastructure\Specification\Factory;


use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\Specification\PointSpecificationFactoryInterface;
use App\Domain\ValueObj\DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr;
use Ramsey\Uuid\UuidInterface;

class OrmPointSpecificationFactory implements PointSpecificationFactoryInterface
{
    /** @var Expr */
    private $expr;

    /**
     * OrmPharmacySpecificationFactory constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->expr = $entityManager->getExpressionBuilder();
    }


    public function createForCountPointsByPharmacyBetweenDates(
        UuidInterface $pharmacyUuid,
        DateTime $dateIni,
        DateTime $dateEnd
    ): SpecificationInterface {
        // TODO: Implement createForCountPointsByPharmacyBetweenDates() method.
    }
}