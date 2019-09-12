<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Domain\Entity\Pharmacy;
use App\Domain\Event\Event\PharmacyWasCreated;
use App\Domain\ValueObj\PharmacyName;
use App\Infrastructure\Doctrine\Model\WriteModel;
use Assert\AssertionFailedException;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class PharmacyFixtures extends Fixture
{
    /** @var WriteModel */
    private $writeModel;


    /**
     * PharmacyFixtures constructor.
     * @param WriteModel $writeModel
     */
    public function __construct(WriteModel $writeModel)
    {
        $this->writeModel = $writeModel;
    }


    /**
     * @param ObjectManager $manager
     * @throws AssertionFailedException|\Exception
     */
    public function load(ObjectManager $manager)
    {
        foreach (['Verdaguer', 'Companys', 'Canigó'] as $name) {
            $uuid         = Uuid::uuid4();
            $pharmacyName = PharmacyName::fromStr(sprintf('Farmacia %s', $name));

            $pharmacy = Pharmacy::create($uuid, $pharmacyName);
            $event    = new PharmacyWasCreated($pharmacy);

            $this->writeModel->queueToPersist($pharmacy, $event);
        }

        $this->writeModel->persist();
    }
}
