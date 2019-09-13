<?php

declare(strict_types=1);

namespace App\Domain\Event\Event;

use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Entity\Point;
use App\Domain\ValueObj\AwardedAt;
use Ramsey\Uuid\UuidInterface;

class PointWasCreated extends AbstractEvent
{
    /** @var UuidInterface */
    public $uuid;

    /** @var Client */
    public $client;

    /** @var Pharmacy */
    public $pharmacy;

    /** @var AwardedAt */
    public $awardedAt;


    /**
     * AwardPointWasCreated constructor.
     * @param Point $point
     */
    public function __construct(Point $point)
    {
        parent::__construct();

        $this->uuid      = $point->getUuid();
        $this->client    = $point->getClient();
        $this->pharmacy  = $point->getPharmacyAwarding();
        $this->awardedAt = $point->getAwardedAt();
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
            'uuid'              => $this->uuid->toString(),
            'client'            => $this->client->getUuid()->toString(),
            'pharmacy_awarding' => $this->pharmacy->getUuid()->toString(),
            'awarded_at'        => $this->awardedAt->toStr(),
        ];
    }
}
