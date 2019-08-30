<?php


namespace App\Domain\ValueObj;


use Assert\Assertion;
use Assert\AssertionFailedException;

class QuantityPoints
{
    /** @var int */
    protected $quantity;


    /**
     * @param int $quantity
     * @return QuantityPoints
     * @throws AssertionFailedException
     */
    public static function fromInt(int $quantity): self
    {
        Assertion::min($quantity, 0, 'Quantity must be greater than zero');

        $instance       = new static();
        $instance->quantity = $quantity;

        return $instance;
    }


    /**
     * @return int
     */
    public function toNumber(): int
    {
        return $this->quantity;
    }


    public function __toString(): string
    {
        return (string) $this->toNumber();
    }


    private function __construct()
    {
    }
}
