<?php

declare(strict_types=1);

namespace App\Application\Command\CreatePoint;

use App\Domain\ValueObj\AwardedAt;
use App\Domain\ValueObj\QuantityPoints;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class CreatePointCommand
{
    private UuidInterface $clientUuid;
    private UuidInterface $pharmacyUuid;
    private QuantityPoints $quantity;
    private AwardedAt $awardedAt;


    public function __construct(string $clientUuid, string $pharmacyUuid, int $points)
    {
        $this->clientUuid   = Uuid::fromString($clientUuid);
        $this->pharmacyUuid = Uuid::fromString($pharmacyUuid);
        $this->quantity     = QuantityPoints::fromInt($points);
        $this->awardedAt    = AwardedAt::now();
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


    public function awardedAt(): AwardedAt
    {
        return $this->awardedAt;
    }
}
