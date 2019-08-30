<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\ValueObj\ClientName;
use Assert\AssertionFailedException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

class ClientNameType extends Type
{
    const NAME = 'clientName';


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
        return sprintf('varchar(%d)', ClientName::MAX_LENGTH);
    }


    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @return ClientName|null
     * @throws AssertionFailedException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?ClientName
    {
        if (null === $value || $value instanceof ClientName) {
            return $value;
        }

        return ClientName::fromStr($value);
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

        if ($value instanceof ClientName) {
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
