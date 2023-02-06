<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\AggregateRoot\AggregateRoot;
use App\Domain\Exception\ClientException;
use App\Domain\Exception\PointException;
use App\Domain\ValueObj\ClientName;
use App\Domain\ValueObj\QuantityPoints;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

class Client extends AggregateRoot
{
    public const ALIAS   = 'c';
    public const NAME    = 'client';
    public const BALANCE = 'balance';

    private UuidInterface $uuid;
    private ClientName $name;
    private Collection $points;


    private function __construct()
    {
        $this->points = new ArrayCollection();
    }


    public static function create(UuidInterface $uuid, ClientName $name): self
    {
        $instance       = new self();
        $instance->uuid = $uuid;
        $instance->name = $name;

        return $instance;
    }


    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }


    public function name(): ClientName
    {
        return $this->name;
    }


    public function addPoint(Point $point): self
    {
        if (!$point->isAvailableForClient()) {
            throw new PointException('Point not allowed for client');
        }

        $this->points->add($point);

        return $this;
    }


    /**
     * @return Point[]
     */
    public function points(QuantityPoints $quantity): array
    {
        if (!$this->hasEnoughPoints($quantity)) {
            throw new ClientException("Client don't has enough points");
        }

        $collection = $this->getAvailablePoints();

        return $collection->slice(0, $quantity->toInt());
    }


    public function getCountAvailablePoints(): int
    {
        return $this->getAvailablePoints()->count();
    }


    private function getAvailablePoints(): ArrayCollection
    {
        return $this->points->filter(function (Point $point) {
            return $point->isAvailableForClient();
        });
    }


    private function hasEnoughPoints(QuantityPoints $quantity): bool
    {
        return $this->getCountAvailablePoints() >= $quantity->toInt();
    }
}
