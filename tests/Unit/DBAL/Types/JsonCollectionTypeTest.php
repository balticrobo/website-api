<?php declare(strict_types=1);

namespace BalticRobo\Api\Tests\Unit\DBAL\Types;

use BalticRobo\Api\DBAL\Types\JsonCollectionType;
use BalticRobo\Api\Exception\DoctrineTypeConversionError;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Platforms as Platform;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \BalticRobo\Api\DBAL\Types\JsonCollectionType
 */
class JsonCollectionTypeTest extends TestCase
{
    private $type;
    private $platform;

    protected function setUp(): void
    {
        $this->type = \Mockery::mock(JsonCollectionType::class)->makePartial();
        $this->platform = new Platform\MySqlPlatform();
    }

    public function testGetName():void
    {
        $name = $this->type->getName();

        Assert::assertSame('json_collection', $name);
    }

    /**
     * @dataProvider getSQLDeclarationDataProvider
     */
    public function testGetSQLDeclaration(string $type, Platform\AbstractPlatform $platform): void
    {
        $declaration = $this->type->getSQLDeclaration([], $platform);

        Assert::assertSame($type, $declaration);
    }

    /**
     * @dataProvider convertToPHPValueDataProvider
     */
    public function testConvertToPHPValue(string $json, array $output): void
    {
        $result = $this->type->convertToPHPValue($json, $this->platform);

        Assert::assertInstanceOf(ArrayCollection::class, $result);
        Assert::assertSame($output, $result->toArray());
    }

    /**
     * @dataProvider convertToPHPValueWrongValuesDataProvider
     */
    public function testConvertToPHPValueWithNotJSON(string $json): void
    {
        $this->expectException(DoctrineTypeConversionError::class);

        $this->type->convertToPHPValue($json, $this->platform);
    }

    /**
     * @dataProvider convertToDatabaseValueDataProvider
     */
    public function testConvertToDatabaseValue(ArrayCollection $collection, string $output): void
    {
        $result = $this->type->convertToDatabaseValue($collection, $this->platform);

        Assert::assertSame($output, $result);
    }

    public function testConvertToDatabaseValueWithNotArrayCollection(): void
    {
        $this->expectException(DoctrineTypeConversionError::class);

        $this->type->convertToDatabaseValue('ROLE_USER', $this->platform);
    }

    public function getSQLDeclarationDataProvider(): \Generator
    {
        yield 'MySQL' => ['LONGTEXT', new Platform\MySqlPlatform()];
        yield 'MySQL 5.7' => ['JSON', new Platform\MySQL57Platform()];
        yield 'MySQL 8.0' => ['JSON', new Platform\MySQL80Platform()];
        yield 'MariaDB 10.2.7' => ['LONGTEXT', new Platform\MariaDb1027Platform()];
        yield 'PostgreSQL' => ['TEXT', new Platform\PostgreSqlPlatform()];
        yield 'PostgreSQL 9.1' => ['TEXT', new Platform\PostgreSQL91Platform()];
        yield 'PostgreSQL 9.2' => ['JSON', new Platform\PostgreSQL92Platform()];
        yield 'PostgreSQL 9.4' => ['JSON', new Platform\PostgreSQL94Platform()];
        yield 'PostgreSQL 10.0' => ['JSON', new Platform\PostgreSQL100Platform()];
        yield 'Sqlite' => ['CLOB', new Platform\SqlitePlatform()];
    }

    public function convertToPHPValueDataProvider(): \Generator
    {
        yield ['[]', []];
        yield ['{}', []];
        yield ['[1,2,3]', [1, 2, 3]];
        yield ['[1, 2, 3]', [1, 2, 3]];
        yield ['["ROLE_USER"]', ['ROLE_USER']];
    }

    public function convertToPHPValueWrongValuesDataProvider(): \Generator
    {
        yield 'empty string' => [''];
        yield 'wrong JSON' => ['{'];
        yield 'wrong JSON' => ['['];
        yield 'bool' => ['true'];
        yield 'string' => ['ROLE_USER'];
    }

    public function convertToDatabaseValueDataProvider(): \Generator
    {
        yield [new ArrayCollection([]), '[]'];
        yield [new ArrayCollection([1, 2, 3]), '[1,2,3]'];
        yield [new ArrayCollection(['ROLE_USER']), '["ROLE_USER"]'];
        yield [new ArrayCollection(['roles' => ['ROLE_USER', 'ROLE_ADMIN']]), '{"roles":["ROLE_USER","ROLE_ADMIN"]}'];
    }
}
