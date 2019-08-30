<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\ValueObj\PharmacyName;
use Assert\AssertionFailedException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

class PharmacyNameType extends Type
{
    const NAME = 'pharmacyName';


    /**
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }


    /**
     * @param  array            $fieldDeclaration
     * @param  AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return sprintf('varchar(%d)', PharmacyName::MAX_LENGTH);
    }


    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @throws AssertionFailedException
     * @return PharmacyName|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?PharmacyName
    {
        if (null === $value || $value instanceof PharmacyName) {
            return $value;
        }

        return PharmacyName::fromStr($value);
    }


    /**
     * @param  mixed               $value
     * @param  AbstractPlatform    $platform
     * @throws ConversionException
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return $value;
        }

        if ($value instanceof PharmacyName) {
            return $value->toStr();
        }

        throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', 'ClientName']);
    }


    /**
     * @param  AbstractPlatform $platform
     * @return bool
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
