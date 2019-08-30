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


    /**
     * @param $obj
     * @param bool $flush
     * @param bool $clear
     */
    public function save($obj, bool $flush = true, bool $clear = false): void
    {
        $this->manager->persist($obj);

        if ($flush) {
            $this->flushDb();
        }

        if ($clear) {
            $this->clearDb();
        }
    }


    /**
     * @param $obj
     * @param bool $flush
     */
    public function update($obj, bool $flush = true): void
    {
        $this->manager->merge($obj);

        if ($flush) {
            $this->flushDb();
        }
    }


    /**
     * @param $obj
     * @param bool $flush
     */
    public function remove($obj, $flush = true): void
    {
        $this->manager->remove($obj);

        if ($flush) {
            $this->flushDb();
        }
    }


    public function flushDb(): void
    {
        $this->manager->flush();
    }


    public function clearDb(): void
    {
        $this->manager->clear();
    }
}
