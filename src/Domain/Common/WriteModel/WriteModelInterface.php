<?php

declare(strict_types=1);

namespace App\Domain\Common\WriteModel;

use Throwable;

interface WriteModelInterface
{
    /**
     * @param object $entity
     * @throws Throwable
     */
    public function save(object $entity): void;

    /**
     * @param object $entity
     * @throws Throwable
     */
    public function update(object $entity): void;

    /**
     * @param object $entity
     * @throws Throwable
     */
    public function delete(object $entity): void;
}
