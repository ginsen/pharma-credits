<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Model;

use App\Domain\Common\WriteModel\WriteModelInterface;
use Doctrine\Common\Persistence\ObjectManager;

class WriteModel implements WriteModelInterface
{
    /** @var ObjectManager */
    private $manager;


    /**
     * WriteModel constructor.
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function save($entity): void
    {
        $this->manager->persist($entity);
        $this->manager->flush();
    }


    public function update($entity): void
    {
        $this->manager->merge($entity);
        $this->manager->flush();
    }


    public function delete($entity): void
    {
        $this->manager->remove($entity);
        $this->manager->flush();
    }
}
