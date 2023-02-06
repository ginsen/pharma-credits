<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Domain\Entity\Client;
use App\Domain\ValueObj\ClientName;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class ClientFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach (['Eric Clapton', 'B.B. King', 'Freddy Mercury'] as $name) {
            $uuid       = Uuid::uuid4();
            $clientName = ClientName::fromStr($name);

            $client = Client::create($uuid, $clientName);
            $manager->persist($client);
        }

        $manager->flush();
    }
}
