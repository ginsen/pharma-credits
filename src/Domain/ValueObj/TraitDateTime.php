<?php

declare(strict_types=1);

namespace App\Domain\ValueObj;

use App\Domain\Exception\DateTimeException;

trait TraitDateTime
{
    /** @var \DateTimeImmutable */
    private $dateTime;


    /**
     * @return self
     */
    public static function now(): self
    {
        return self::create();
    }


    /**
     * @param  string $time
     * @return self
     */
    public static function fromStr(string $time): self
    {
        return static::create($time);
    }


    /**
     * @param  string   $time
     * @return self
     */
    private static function create(string $time = ''): self
    {
        $instance = new static();

        try {
            $instance->dateTime = new \DateTimeImmutable($time);
        } catch (\Exception $e) {
            throw new DateTimeException($e);
        }

        return $instance;
    }


    /**
     * @return string
     */
    public function toStr(): string
    {
        return $this->dateTime->format(self::FORMAT);
    }


    /**
     * @return \DateTimeImmutable
     */
    public function toDateTime(): \DateTimeImmutable
    {
        return $this->dateTime;
    }


    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toStr();
    }


    protected function __construct()
    {
    }
}
