<?php

declare(strict_types=1);

namespace App\Domain\Common\WriteModel;

interface WriteModelInterface
{
    public function save($entity): void;

    public function update($entity): void;

    public function delete($entity): void;
}
