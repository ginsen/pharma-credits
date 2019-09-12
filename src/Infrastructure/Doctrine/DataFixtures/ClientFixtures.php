<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Domain\Entity\Client;
use App\Domain\Event\Event\ClientWasCreated;
use App\Domain\ValueObj\ClientName;
use App\Infrastructure\Doctrine\Model\WriteModel;
use Assert\AssertionFailedException;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class ClientFixtures extends Fixture
{
    /** @var WriteModel */
    private $writeModel;


    /**
     * ClientFixtures constructor.
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
        foreach (['Eric Clapton', 'B.B. King', 'Freddy Mercury'] as $name) {
            $uuid       = Uuid::uuid4();
            $clientName = ClientName::fromStr($name);

            $client = Client::create($uuid, $clientName);
            $event  = new ClientWasCreated($client);

            $this->writeModel->queueToPersist($client, $event);
        }

        $this->writeModel->persist();
    }
}
