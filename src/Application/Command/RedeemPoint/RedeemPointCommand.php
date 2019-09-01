<?php

declare(strict_types=1);

namespace App\Application\Command\RedeemPoint;

use App\Domain\ValueObj\QuantityPoints;
use App\Domain\ValueObj\RedeemedAt;
use Assert\AssertionFailedException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class RedeemPointCommand
{
    /** @var UuidInterface */
    public $clientUuid;

    /** @var UuidInterface */
    public $pharmacyUuid;

    /** @var QuantityPoints */
    public $quantity;

    /** @var RedeemedAt */
    public $redeemedAt;


    /**
     * CreatePointsCommand constructor.
     * @param string $clientUuid
     * @param string $pharmacyUuid
     * @param int    $points
     * @throws AssertionFailedException
     */
    public function __construct(string $clientUuid, string $pharmacyUuid, int $points)
    {
        $this->clientUuid   = Uuid::fromString($clientUuid);
        $this->pharmacyUuid = Uuid::fromString($pharmacyUuid);
        $this->quantity     = QuantityPoints::fromInt($points);
        $this->redeemedAt   = RedeemedAt::now();
    }
}
