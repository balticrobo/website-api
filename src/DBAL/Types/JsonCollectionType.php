<?php declare(strict_types=1);

namespace BalticRobo\Api\DBAL\Types;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class JsonCollectionType extends Type
{
    private const DOCTRINE_REPRESENTATION = 'json_collection';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getJsonTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Collection
    {
        return new ArrayCollection(json_decode($value, true));
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?array
    {
        return $value->toArray();
    }

    public function getName()
    {
        return self::DOCTRINE_REPRESENTATION;
    }
}
