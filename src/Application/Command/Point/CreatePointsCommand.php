<?php

declare(strict_types=1);

namespace App\Application\Command\Point;

use App\Domain\ValueObj\AwardedAt;
use App\Domain\ValueObj\QuantityPoints;
use Assert\AssertionFailedException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class CreatePointsCommand
{
    /** @var UuidInterface */
    public $clientUuid;

    /** @var UuidInterface */
    public $pharmacyUuid;

    /** @var QuantityPoints */
    public $quantity;

    /** @var AwardedAt */
    public $awardedAt;


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
        $this->awardedAt    = AwardedAt::now();
    }
}
