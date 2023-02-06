<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Exception\DateTimeException;
use App\Domain\ValueObj\RedeemedAt;
use DateTimeImmutable;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeImmutableType;

class RedeemedAtType extends DateTimeImmutableType
{
    public const NAME = 'redeemedAt';


    /**
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }


    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'DateTime';
    }


    /**
     * {@inheritdoc}
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof RedeemedAt) {
            return $value->toDateTime()->format($platform->getDateTimeFormatString());
        }

        if ($value instanceof DateTimeImmutable) {
            return $value->format($platform->getDateTimeFormatString());
        }

        throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', RedeemedAt::class]);
    }


    public function convertToPHPValue($value, AbstractPlatform $platform): ?RedeemedAt
    {
        if (null === $value || $value instanceof RedeemedAt) {
            return $value;
        }

        try {
            $dateTime = RedeemedAt::fromStr($value);
        } catch (DateTimeException) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getDateTimeFormatString());
        }

        return $dateTime;
    }
}
