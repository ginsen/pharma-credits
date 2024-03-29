<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Domain\Entity\Pharmacy;
use App\Domain\ValueObj\PharmacyName;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class PharmacyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach (['Verdaguer', 'Companys', 'Canigó'] as $name) {
            $uuid         = Uuid::uuid4();
            $pharmacyName = PharmacyName::fromStr(sprintf('Farmacia %s', $name));

            $pharmacy = Pharmacy::create($uuid, $pharmacyName);
            $manager->persist($pharmacy);
        }

        $manager->flush();
    }
}
