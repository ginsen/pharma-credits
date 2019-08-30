<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObj\AwardedAt;
use App\Domain\ValueObj\RedeemedAt;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Point
{
    /** @var UuidInterface */
    protected $uuid;

    /** @var Client */
    protected $client;

    /** @var Pharmacy */
    protected $pharmacyDispensing;

    /** @var Pharmacy */
    protected $pharmacyRedeeming;

    /** @var AwardedAt */
    protected $awardedAt;

    /** @var RedeemedAt */
    protected $redeemedAt;


    /**
     * Point constructor.
     */
    protected function __construct()
    {
    }


    /**
     * @param Client $client
     * @param Pharmacy $pharmacy
     * @param AwardedAt $time
     * @return Point
     * @throws \Exception
     */
    public static function createAwardPoint(Client $client, Pharmacy $pharmacy, AwardedAt $time): self
    {
        $instance = new self();

        $instance->uuid = Uuid::uuid4();
        $instance->setClient($client);
        $instance->setPharmacyDispensing($pharmacy);
        $instance->setAwardedAt($time);

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
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }


    /**
     * @param Client $client
     * @return Point
     */
    public function setClient(Client $client): Point
    {
        $client->addPoint($this);
        $this->client = $client;

        return $this;
    }


    /**
     * @return Pharmacy
     */
    public function getPharmacyDispensing(): Pharmacy
    {
        return $this->pharmacyDispensing;
    }


    /**
     * @param Pharmacy $pharmacy
     * @return Point
     */
    public function setPharmacyDispensing(Pharmacy $pharmacy): Point
    {
        $pharmacy->addDispensedPoint($this);
        $this->pharmacyDispensing = $pharmacy;

        return $this;
    }


    /**
     * @return Pharmacy
     */
    public function getPharmacyRedeeming(): Pharmacy
    {
        return $this->pharmacyRedeeming;
    }


    /**
     * @param Pharmacy $pharmacy
     * @return Point
     */
    public function setPharmacyRedeeming(Pharmacy $pharmacy): Point
    {
        $pharmacy->addRedeemingPoint($this);
        $this->pharmacyRedeeming = $pharmacy;

        return $this;
    }


    /**
     * @return AwardedAt
     */
    public function getAwardedAt(): AwardedAt
    {
        return $this->awardedAt;
    }


    /**
     * @param AwardedAt $awardedAt
     * @return Point
     */
    public function setAwardedAt(AwardedAt $awardedAt): Point
    {
        $this->awardedAt = $awardedAt;
        return $this;
    }


    /**
     * @return RedeemedAt
     */
    public function getRedeemedAt(): RedeemedAt
    {
        return $this->redeemedAt;
    }


    /**
     * @param RedeemedAt $redeemedAt
     * @return Point
     */
    public function setRedeemedAt(RedeemedAt $redeemedAt): Point
    {
        $this->redeemedAt = $redeemedAt;
        return $this;
    }


    /**
     * @return bool
     */
    public function isAvailableForClient(): bool
    {
        return empty($this->pharmacyRedeeming);
    }
}
