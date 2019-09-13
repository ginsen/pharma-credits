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


    public function queueToPersist($entity): void
    {
        $this->manager->persist($entity);
    }


    public function persist(): void
    {
        $this->manager->flush();
    }


    public function clearQueue(): void
    {
        $this->manager->clear();
    }
}
