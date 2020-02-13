<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Model;

use App\Domain\Common\WriteModel\WriteModelInterface;
use Doctrine\ORM\EntityManagerInterface;

class WriteModel implements WriteModelInterface
{
    /** @var EntityManagerInterface */
    private $manager;


    /**
     * WriteModel constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    /**
     * {@inheritDoc}
     */
    public function save(object $entity): void
    {
        $this->manager->persist($entity);
        $this->manager->flush();
    }


    /**
     * {@inheritDoc}
     */
    public function update(object $entity): void
    {
        $this->manager->persist($entity);
        $this->manager->flush();
    }


    /**
     * {@inheritDoc}
     */
    public function delete(object $entity): void
    {
        $this->manager->remove($entity);
        $this->manager->flush();
    }
}
