<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObj\PharmacyName;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\UuidInterface;

final class Pharmacy
{
    /** @var UuidInterface */
    private $uuid;

    /** @var PharmacyName */
    private $name;

    /** @var ArrayCollection */
    private $dispensingPoints;

    /** @var ArrayCollection */
    private $redeemingPoints;


    /**
     * Pharmacy constructor.
     */
    private function __construct()
    {
        $this->dispensingPoints = new ArrayCollection();
        $this->redeemingPoints  = new ArrayCollection();
    }


    /**
     * @param UuidInterface $uuid
     * @param PharmacyName $name
     * @return self
     */
    public static function create(UuidInterface $uuid, PharmacyName $name): self
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
    public function setName(PharmacyName $name): self
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @param Point $point
     * @return self
     */
    public function addDispensedPoint(Point $point): self
    {
        $this->dispensingPoints->add($point);
        return $this;
    }


    /**
     * @param Point $point
     * @return self
     */
    public function removeDispensedPoint(Point $point): self
    {
        $this->dispensingPoints->removeElement($point);
        return $this;
    }


    /**
     * @return ArrayCollection
     */
    public function getDispensedPoints(): ArrayCollection
    {
        return $this->dispensingPoints;
    }


    /**
     * @param Point $point
     * @return self
     */
    public function addRedeemingPoint(Point $point): self
    {
        $this->redeemingPoints->add($point);
        return $this;
    }


    /**
     * @param Point $point
     * @return self
     */
    public function removeRedeemingPoint(Point $point): self
    {
        $this->redeemingPoints->removeElement($point);
        return $this;
    }


    /**
     * @return ArrayCollection
     */
    public function getRedeemingPoints(): ArrayCollection
    {
        return $this->redeemingPoints;
    }
}
