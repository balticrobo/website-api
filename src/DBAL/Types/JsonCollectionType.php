<?php declare(strict_types=1);

namespace BalticRobo\Api\DBAL\Types;

use BalticRobo\Api\Exception\DoctrineTypeConversionError;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class JsonCollectionType extends Type
{
    private const DOCTRINE_REPRESENTATION = 'json_collection';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getJsonTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Collection
    {
        $array = json_decode($value, true);
        if (!is_array($array)) {
            throw new DoctrineTypeConversionError();
        }

        return new ArrayCollection($array);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if (!$value instanceof ArrayCollection) {
            throw new DoctrineTypeConversionError();
        }

        return json_encode($value->toArray());
    }

    public function getName(): string
    {
        return self::DOCTRINE_REPRESENTATION;
    }
}
