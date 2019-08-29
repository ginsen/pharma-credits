<?php

declare(strict_types=1);

namespace App\Domain\ValueObj;

use Assert\Assertion;
use Assert\AssertionFailedException;

trait TraitName
{
    /** @var string */
    protected $name;


    /**
     * @param string $name
     * @throws AssertionFailedException
     * @return self
     */
    public static function fromStr(string $name): self
    {
        Assertion::maxLength($name, static::MAX_LENGTH, 'Name is too long');

        $instance       = new static();
        $instance->name = $name;

        return $instance;
    }


    /**
     * @return string
     */
    public function toStr(): string
    {
        return $this->name;
    }


    public function __toString(): string
    {
        return $this->toStr();
    }

    private function __construct()
    {
    }
}
