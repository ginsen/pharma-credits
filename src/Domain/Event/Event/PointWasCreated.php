<?php

declare(strict_types=1);

namespace App\Domain\Event\Event;

use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Entity\Point;
use App\Domain\Event\Common\AbstractEvent;
use App\Domain\ValueObj\AwardedAt;
use Ramsey\Uuid\UuidInterface;

class PointWasCreated extends AbstractEvent
{
    public UuidInterface $uuid;
    public Client $client;
    public Pharmacy $pharmacy;
    public AwardedAt $awardedAt;


    public function __construct(Point $point)
    {
        parent::__construct();

        $this->uuid      = $point->uuid();
        $this->client    = $point->client();
        $this->pharmacy  = $point->pharmacyAwarding();
        $this->awardedAt = $point->awardedAt();
    }


    protected function index(): string
    {
        return $this->uuid->toString();
    }


    protected function payload(): array
    {
        return [
            'uuid'              => $this->uuid->toString(),
            'client'            => $this->client->uuid()->toString(),
            'pharmacy_awarding' => $this->pharmacy->uuid()->toString(),
            'awarded_at'        => $this->awardedAt->toStr(),
        ];
    }
}
