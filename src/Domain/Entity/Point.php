<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\AggregateRoot\AggregateRoot;
use App\Domain\Event\Event\PointWasCreated;
use App\Domain\Event\Event\PointWasRedeemed;
use App\Domain\ValueObj\AwardedAt;
use App\Domain\ValueObj\RedeemedAt;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Point extends AggregateRoot
{
    public const ALIAS          = 'po';
    public const POINTS         = 'points';
    public const AWARDED_POINTS = 'awarded_points';
    public const FROM           = 'from';
    public const TO             = 'to';

    protected UuidInterface $uuid;
    protected Client $client;
    protected Pharmacy $pharmacyAwarding;
    protected Pharmacy $pharmacyRedeeming;
    protected AwardedAt $awardedAt;
    protected RedeemedAt $redeemedAt;


    public static function createAwardPoint(Client $client, Pharmacy $pharmacy, AwardedAt $time): self
    {
        $instance = new self();

        $instance->uuid = Uuid::uuid4();
        $instance->setClient($client);
        $instance->setPharmacyAwarding($pharmacy);
        $instance->setAwardedAt($time);

        $instance->publish(new PointWasCreated($instance));

        return $instance;
    }


    public function redeem(Pharmacy $pharmacy, RedeemedAt $time): self
    {
        $this->setPharmacyRedeeming($pharmacy);
        $this->setRedeemedAt($time);

        $this->publish(new PointWasRedeemed($this));

        return $this;
    }


    public function isAvailableForClient(): bool
    {
        return empty($this->pharmacyRedeeming);
    }


    protected function setClient(Client $client): self
    {
        $client->addPoint($this);
        $this->client = $client;

        return $this;
    }


    protected function setPharmacyAwarding(Pharmacy $pharmacy): self
    {
        $pharmacy->addAwardedPoint($this);
        $this->pharmacyAwarding = $pharmacy;

        return $this;
    }


    protected function setPharmacyRedeeming(Pharmacy $pharmacy): self
    {
        $pharmacy->addRedeemedPoint($this);
        $this->pharmacyRedeeming = $pharmacy;

        return $this;
    }


    protected function setAwardedAt(AwardedAt $awardedAt): self
    {
        $this->awardedAt = $awardedAt;

        return $this;
    }


    protected function setRedeemedAt(RedeemedAt $redeemedAt): self
    {
        $this->redeemedAt = $redeemedAt;

        return $this;
    }


    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }


    public function client(): Client
    {
        return $this->client;
    }


    public function pharmacyAwarding(): Pharmacy
    {
        return $this->pharmacyAwarding;
    }


    public function pharmacyRedeeming(): Pharmacy
    {
        return $this->pharmacyRedeeming;
    }


    public function awardedAt(): AwardedAt
    {
        return $this->awardedAt;
    }


    public function redeemedAt(): RedeemedAt
    {
        return $this->redeemedAt;
    }


    protected function __construct()
    {
    }
}
