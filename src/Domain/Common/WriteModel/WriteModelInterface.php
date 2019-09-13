<?php

declare(strict_types=1);

namespace App\Domain\Common\WriteModel;

interface WriteModelInterface
{
    public function queueToPersist($entity): void;

    public function persist(): void;

    public function clearQueue(): void;
}
