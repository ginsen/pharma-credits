<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\AggregateRoot\AggregateRoot;
use App\Domain\Event\Event\PharmacyWasCreated;
use App\Domain\ValueObj\PharmacyName;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\UuidInterface;

class Pharmacy extends AggregateRoot
{
    /** @var UuidInterface */
    private $uuid;

    /** @var PharmacyName */
    private $name;

    /** @var ArrayCollection */
    private $awardedPoints;

    /** @var ArrayCollection */
    private $redeemedPoints;


    /**
     * Pharmacy constructor.
     */
    private function __construct()
    {
        $this->awardedPoints  = new ArrayCollection();
        $this->redeemedPoints = new ArrayCollection();
    }


    /**
     * @param UuidInterface $uuid
     * @param PharmacyName  $name
     * @return self
     */
    public static function create(UuidInterface $uuid, PharmacyName $name): self
    {
        $instance       = new self();
        $instance->uuid = $uuid;
        $instance->setName($name);

        $instance->queueEvent(new PharmacyWasCreated($instance));

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
     * @return PharmacyName
     */
    public function getName(): PharmacyName
    {
        return $this->name;
    }


    /**
     * @param PharmacyName $name
     * @return self
     */
    protected function setName(PharmacyName $name): self
    {
        $this->name = $name;

        return $this;
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
     * @return ArrayCollection|Point[]
     */
    public function getAwardedPoints(): ArrayCollection
    {
        return $this->awardedPoints;
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
     * @return ArrayCollection|Point[]
     */
    public function getRedeemedPoints(): ArrayCollection
    {
        return $this->redeemedPoints;
    }
}
