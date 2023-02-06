<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\ValueObj\ClientName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

class ClientNameType extends Type
{
    public const NAME = 'clientName';


    public function getName(): string
    {
        return static::NAME;
    }


    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return sprintf('varchar(%d)', ClientName::MAX_LENGTH);
    }


    public function convertToPHPValue($value, AbstractPlatform $platform): ?ClientName
    {
        if (null === $value || $value instanceof ClientName) {
            return $value;
        }

        return ClientName::fromStr($value);
    }


    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof ClientName) {
            return $value->toStr();
        }

        throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', 'ClientName']);
    }


    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
