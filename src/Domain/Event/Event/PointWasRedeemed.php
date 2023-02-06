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
    public UuidInterface $uuid;
    public Client $client;
    public Pharmacy $pharmacy;
    public RedeemedAt $redeemedAt;


    public function __construct(Point $point)
    {
        parent::__construct();

        $this->uuid       = $point->uuid();
        $this->client     = $point->client();
        $this->pharmacy   = $point->pharmacyRedeeming();
        $this->redeemedAt = $point->redeemedAt();
    }


    protected function index(): string
    {
        return $this->uuid->toString();
    }


    protected function payload(): array
    {
        return [
            'uuid'               => $this->uuid->toString(),
            'client'             => $this->client->uuid()->toString(),
            'pharmacy_redeeming' => $this->pharmacy->uuid()->toString(),
            'redeemed_at'        => $this->redeemedAt->toStr(),
        ];
    }
}
