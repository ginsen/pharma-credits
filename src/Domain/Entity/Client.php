<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\AggregateRoot\AggregateRoot;
use App\Domain\Exception\ClientException;
use App\Domain\Exception\PointException;
use App\Domain\ValueObj\ClientName;
use App\Domain\ValueObj\QuantityPoints;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\UuidInterface;

class Client extends AggregateRoot
{
    /** @var UuidInterface */
    private $uuid;

    /** @var ClientName */
    private $name;

    /** @var ArrayCollection */
    private $points;


    private function __construct()
    {
        $this->points = new ArrayCollection();
    }


    /**
     * @param UuidInterface $uuid
     * @param ClientName    $name
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
    protected function setName(ClientName $name): self
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
     * @param QuantityPoints $quantity
     * @return Point[]
     */
    public function getPoints(QuantityPoints $quantity): array
    {
        if (!$this->hasEnoughPoints($quantity)) {
            throw new ClientException("Client don't has enough points");
        }

        $collection = $this->getAvailablePoints();

        return $collection->slice(0, $quantity->toNumber());
    }


    /**
     * @return ArrayCollection|Point[]
     */
    public function getAvailablePoints(): ArrayCollection
    {
        return $this->points->filter(function (Point $point) {
            return $point->isAvailableForClient();
        });
    }


    /**
     * @return int
     */
    public function getCountAvailablePoints(): int
    {
        return \count($this->getAvailablePoints());
    }


    /**
     * @param QuantityPoints $quantity
     * @return bool
     */
    protected function hasEnoughPoints(QuantityPoints $quantity): bool
    {
        return $this->getCountAvailablePoints() >= $quantity->toNumber();
    }
}
