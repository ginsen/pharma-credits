<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Exception\PointException;
use App\Domain\ValueObj\ClientName;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\UuidInterface;

final class Client
{
    /** @var UuidInterface */
    private $uuid;

    /** @var ClientName */
    private $name;

    /** @var ArrayCollection */
    private $points;


    /**
     * Client constructor.
     */
    private function __construct()
    {
        $this->points = new ArrayCollection();
    }


    /**
     * @param UuidInterface $uuid
     * @param ClientName $name
     * @return self
     */
    public static function create(UuidInterface $uuid, ClientName $name): self
    {
        $instance       = new self();
        $instance->uuid = $uuid;
        $instance->setName($name);

        return $instance;
    }


    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }


    /**
     * @return ClientName
     */
    public function getName(): ClientName
    {
        return $this->name;
    }


    /**
     * @param ClientName $name
     * @return self
     */
    public function setName(ClientName $name): self
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @param Point $point
     * @return self
     */
    public function addPoint(Point $point): self
    {
        if (!$point->isAvailableForClient()) {
             throw new PointException('Point not allowed for client');
        }

        $this->points->add($point);
        return $this;
    }


    /**
     * @param Point $point
     * @return self
     */
    public function removePoint(Point $point): self
    {
        $this->points->removeElement($point);
        return $this;
    }


    /**
     * @return ArrayCollection
     */
    public function getAvailablePoints(): ArrayCollection
    {
        return $this->points->filter(function(Point $point) {
            return $point->isAvailableForClient();
        });
    }


    /**
     * @return int
     */
    public function getCountAvailablePoints(): int
    {
        return count($this->getAvailablePoints());
    }
}

