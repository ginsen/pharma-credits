<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\AggregateRoot\AggregateRoot;
use App\Domain\ValueObj\PharmacyName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

class Pharmacy extends AggregateRoot
{
    public const ALIAS = 'pa';
    public const NAME  = 'pharmacy';

    private UuidInterface $uuid;
    private PharmacyName $name;
    private Collection $awardedPoints;
    private Collection $redeemedPoints;


    private function __construct()
    {
        $this->awardedPoints  = new ArrayCollection();
        $this->redeemedPoints = new ArrayCollection();
    }


    public static function create(UuidInterface $uuid, PharmacyName $name): self
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


    public function name(): PharmacyName
    {
        return $this->name;
    }


    /**
     * @param Point $point
     * @return self
     */
    public function addAwardedPoint(Point $point): self
    {
        $this->awardedPoints->add($point);

        return $this;
    }


    /**
     * @return Point[]
     */
    public function awardedPoints(): array
    {
        return $this->awardedPoints->toArray();
    }


    /**
     * @param Point $point
     * @return self
     */
    public function addRedeemedPoint(Point $point): self
    {
        $this->redeemedPoints->add($point);

        return $this;
    }


    /**
     * @return Point[]
     */
    public function redeemedPoints(): array
    {
        return $this->redeemedPoints->toArray();
    }
}
