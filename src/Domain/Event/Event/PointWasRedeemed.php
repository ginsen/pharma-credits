<?php

declare(strict_types=1);

namespace App\Domain\Event\Event;

use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Entity\Point;
use App\Domain\Event\Common\AbstractEvent;
use App\Domain\ValueObj\RedeemedAt;
use Ramsey\Uuid\UuidInterface;

class PointWasRedeemed extends AbstractEvent
{
    /** @var UuidInterface */
    public $uuid;

    /** @var Client */
    public $client;

    /** @var Pharmacy */
    public $pharmacy;

    /** @var RedeemedAt */
    public $redeemedAt;


    /**
     * PointWasRedeemed constructor.
     * @param Point $point
     */
    public function __construct(Point $point)
    {
        parent::__construct();

        $this->uuid       = $point->getUuid();
        $this->client     = $point->getClient();
        $this->pharmacy   = $point->getPharmacyRedeeming();
        $this->redeemedAt = $point->getRedeemedAt();
    }


    /**
     * {@inheritDoc}
     */
    protected function index(): string
    {
        return $this->uuid->toString();
    }


    /**
     * {@inheritdoc}
     */
    protected function payload(): array
    {
        return [
            'uuid'               => $this->uuid->toString(),
            'client'             => $this->client->getUuid()->toString(),
            'pharmacy_redeeming' => $this->pharmacy->getUuid()->toString(),
            'redeemed_at'        => $this->redeemedAt->toStr(),
        ];
    }
}
