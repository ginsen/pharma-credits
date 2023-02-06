<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Exception\DateTimeException;
use App\Domain\ValueObj\AwardedAt;
use DateTimeImmutable;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeImmutableType;

class AwardedAtType extends DateTimeImmutableType
{
    public const NAME = 'awardedAt';


    /**
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }


    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'DateTime';
    }


    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof AwardedAt) {
            return $value->toDateTime()->format($platform->getDateTimeFormatString());
        }

        if ($value instanceof DateTimeImmutable) {
            return $value->format($platform->getDateTimeFormatString());
        }

        throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', AwardedAt::class]);
    }


    public function convertToPHPValue($value, AbstractPlatform $platform): ?AwardedAt
    {
        if (null === $value || $value instanceof AwardedAt) {
            return $value;
        }

        try {
            $dateTime = AwardedAt::fromStr($value);
        } catch (DateTimeException) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getDateTimeFormatString());
        }

        return $dateTime;
    }
}
