<?php

declare(strict_types=1);

namespace App\Domain\Common\WriteModel;

interface WriteModelInterface
{
    public function loadToStorage($obj): void;

    public function save(): void;
}
