<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\ValueObj\PharmacyName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

class PharmacyNameType extends Type
{
    public const NAME = 'pharmacyName';


    /**
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }


    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return sprintf('varchar(%d)', PharmacyName::MAX_LENGTH);
    }



    public function convertToPHPValue($value, AbstractPlatform $platform): ?PharmacyName
    {
        if (null === $value || $value instanceof PharmacyName) {
            return $value;
        }

        return PharmacyName::fromStr($value);
    }


    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof PharmacyName) {
            return $value->toStr();
        }

        throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', 'ClientName']);
    }


    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
