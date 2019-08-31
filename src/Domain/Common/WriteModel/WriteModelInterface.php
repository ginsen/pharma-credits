<?php

declare(strict_types=1);

namespace App\Domain\Common\WriteModel;

interface WriteModelInterface
{
    public function queueToPersist($obj): void;

    public function persist(): void;

    public function clearQueue(): void;
}
