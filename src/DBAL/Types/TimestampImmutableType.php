<?php declare(strict_types=1);

namespace BalticRobo\Api\DBAL\Types;

use BalticRobo\Api\Exception\DoctrineTypeConversionError;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class TimestampImmutableType extends Type
{
    private const DOCTRINE_REPRESENTATION = 'timestamp_immutable';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?\DateTimeImmutable
    {
        if (null === $value) {
            return $value;
        }
        if (!is_numeric($value)) {
            throw new DoctrineTypeConversionError();
        }

        return new \DateTimeImmutable("@{$value}");
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        if (null === $value) {
            return $value;
        }
        if (!$value instanceof \DateTimeImmutable) {
            throw new DoctrineTypeConversionError();
        }

        return $value->getTimestamp();
    }

    public function getName(): string
    {
        return self::DOCTRINE_REPRESENTATION;
    }
}
