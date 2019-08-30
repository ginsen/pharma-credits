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
     * @param Client    $client
     * @param Pharmacy  $pharmacy
     * @param AwardedAt $time
     * @throws \Exception
     * @return Point
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


    public function exchangePoint(Pharmacy $pharmacy, RedeemedAt $time): self
    {
        $this->setPharmacyRedeeming($pharmacy);
        $this->setRedeemedAt($time);

        return $this;
    }


    /**
     * @return bool
     */
    public function isAvailableForClient(): bool
    {
        return empty($this->pharmacyRedeeming);
    }


    /**
     * @param Client $client
     * @return Point
     */
    protected function setClient(Client $client): self
    {
        $client->addPoint($this);
        $this->client = $client;

        return $this;
    }


    /**
     * @param Pharmacy $pharmacy
     * @return Point
     */
    protected function setPharmacyDispensing(Pharmacy $pharmacy): self
    {
        $pharmacy->addDispensedPoint($this);
        $this->pharmacyDispensing = $pharmacy;

        return $this;
    }


    /**
     * @param Pharmacy $pharmacy
     * @return Point
     */
    protected function setPharmacyRedeeming(Pharmacy $pharmacy): self
    {
        $pharmacy->addRedeemingPoint($this);
        $this->pharmacyRedeeming = $pharmacy;

        return $this;
    }


    /**
     * @param AwardedAt $awardedAt
     * @return Point
     */
    protected function setAwardedAt(AwardedAt $awardedAt): self
    {
        $this->awardedAt = $awardedAt;

        return $this;
    }


    /**
     * @param RedeemedAt $redeemedAt
     * @return Point
     */
    protected function setRedeemedAt(RedeemedAt $redeemedAt): self
    {
        $this->redeemedAt = $redeemedAt;

        return $this;
    }


    /**
     * Point constructor.
     */
    protected function __construct()
    {
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
     * @return Pharmacy
     */
    public function getPharmacyDispensing(): Pharmacy
    {
        return $this->pharmacyDispensing;
    }


    /**
     * @return Pharmacy
     */
    public function getPharmacyRedeeming(): Pharmacy
    {
        return $this->pharmacyRedeeming;
    }


    /**
     * @return AwardedAt
     */
    public function getAwardedAt(): AwardedAt
    {
        return $this->awardedAt;
    }


    /**
     * @return RedeemedAt
     */
    public function getRedeemedAt(): RedeemedAt
    {
        return $this->redeemedAt;
    }
}
