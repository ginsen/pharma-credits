<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\ValueObj\AwardedAt;

interface PointCountFinderInterface
{
    public function countAwardPointsBetweenDates(Pharmacy $pharmacy, AwardedAt $dateInit, AwardedAt $dateEnd): int;

    public function countAwardPointsClient(Pharmacy $pharmacy, Client $client): int;
}
