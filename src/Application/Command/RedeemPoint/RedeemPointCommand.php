<?php

declare(strict_types=1);

namespace App\Application\Command\RedeemPoint;

use App\Domain\ValueObj\QuantityPoints;
use App\Domain\ValueObj\RedeemedAt;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class RedeemPointCommand
{
    private UuidInterface $clientUuid;
    private UuidInterface $pharmacyUuid;
    private QuantityPoints $quantity;
    private RedeemedAt $redeemedAt;


    public function __construct(string $clientUuid, string $pharmacyUuid, int $points)
    {
        $this->clientUuid   = Uuid::fromString($clientUuid);
        $this->pharmacyUuid = Uuid::fromString($pharmacyUuid);
        $this->quantity     = QuantityPoints::fromInt($points);
        $this->redeemedAt   = RedeemedAt::now();
    }


    public function clientUuid(): UuidInterface
    {
        return $this->clientUuid;
    }


    public function pharmacyUuid(): UuidInterface
    {
        return $this->pharmacyUuid;
    }


    public function quantity(): QuantityPoints
    {
        return $this->quantity;
    }


    public function redeemedAt(): RedeemedAt
    {
        return $this->redeemedAt;
    }
}
