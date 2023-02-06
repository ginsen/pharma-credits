<?php

declare(strict_types=1);

namespace App\Domain\ValueObj;

use Assert\Assertion;

class QuantityPoints
{
    protected int $quantity;


    /**
     * @throws
     */
    public static function fromInt(int $quantity): self
    {
        Assertion::min($quantity, 1, 'Quantity must be greater than zero');

        $instance           = new static();
        $instance->quantity = $quantity;

        return $instance;
    }


    /**
     * @return int
     */
    public function toInt(): int
    {
        return $this->quantity;
    }


    public function __toString(): string
    {
        return (string) $this->toInt();
    }


    private function __construct()
    {
    }
}
