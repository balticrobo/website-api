<?php declare(strict_types=1);

namespace BalticRobo\Api\Tests\Unit\DBAL\Types;

use BalticRobo\Api\DBAL\Types\TimestampImmutableType;
use BalticRobo\Api\Exception\DoctrineTypeConversionError;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Platforms as Platform;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \BalticRobo\Api\DBAL\Types\TimestampImmutableType
 */
class TimestampImmutableTypeTest extends TestCase
{
    private $type;
    private $platform;

    protected function setUp(): void
    {
        $this->type = \Mockery::mock(TimestampImmutableType::class)->makePartial();
        $this->platform = new Platform\MySqlPlatform();
    }

    public function testGetName():void
    {
        $name = $this->type->getName();

        Assert::assertSame('timestamp_immutable', $name);
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
    public function testConvertToPHPValue(int $timestamp, string $output): void
    {
        /** @var \DateTimeImmutable $result */
        $result = $this->type->convertToPHPValue($timestamp, $this->platform);

        Assert::assertInstanceOf(\DateTimeImmutable::class, $result);
        Assert::assertSame($output, $result->format('Y-m-d H:i:s'));
        Assert::assertSame('+00:00', $result->getTimezone()->getName());
    }

    public function testConvertToPHPValueWithNumericString(): void
    {
        $result = $this->type->convertToPHPValue('0', $this->platform);

        Assert::assertInstanceOf(\DateTimeImmutable::class, $result);
        Assert::assertSame('1970-01-01 00:00:00', $result->format('Y-m-d H:i:s'));
        Assert::assertSame('+00:00', $result->getTimezone()->getName());
    }

    public function testConvertToPHPValueWithNull(): void
    {
        $result = $this->type->convertToPHPValue(null, $this->platform);

        Assert::assertNull($result);
    }

    public function testConvertToPHPValueWithNotTimestamp(): void
    {
        $this->expectException(DoctrineTypeConversionError::class);

        $this->type->convertToPHPValue('test', $this->platform);
    }

    /**
     * @dataProvider convertToDatabaseValueDataProvider
     */
    public function testConvertToDatabaseValue(\DateTimeImmutable $date, int $output): void
    {
        $result = $this->type->convertToDatabaseValue($date, $this->platform);

        Assert::assertSame($output, $result);
    }

    public function testConvertToDatabaseValueWithNull(): void
    {
        $result = $this->type->convertToDatabaseValue(null, $this->platform);

        Assert::assertNull($result);
    }

    public function testConvertToDatabaseValueWithNotDateTimeImmutable(): void
    {
        $this->expectException(DoctrineTypeConversionError::class);

        $this->type->convertToDatabaseValue(0, $this->platform);
    }

    public function getSQLDeclarationDataProvider(): \Generator
    {
        yield 'MySQL' => ['INT', new Platform\MySqlPlatform()];
        yield 'MySQL 5.7' => ['INT', new Platform\MySQL57Platform()];
        yield 'MySQL 8.0' => ['INT', new Platform\MySQL80Platform()];
        yield 'MariaDB 10.2.7' => ['INT', new Platform\MariaDb1027Platform()];
        yield 'PostgreSQL' => ['INT', new Platform\PostgreSqlPlatform()];
        yield 'PostgreSQL 9.1' => ['INT', new Platform\PostgreSQL91Platform()];
        yield 'PostgreSQL 9.2' => ['INT', new Platform\PostgreSQL92Platform()];
        yield 'PostgreSQL 9.4' => ['INT', new Platform\PostgreSQL94Platform()];
        yield 'PostgreSQL 10.0' => ['INT', new Platform\PostgreSQL100Platform()];
        yield 'Sqlite' => ['INTEGER', new Platform\SqlitePlatform()];
    }

    public function convertToPHPValueDataProvider(): \Generator
    {
        yield [-1, '1969-12-31 23:59:59'];
        yield [0, '1970-01-01 00:00:00'];
        yield [1, '1970-01-01 00:00:01'];
        yield [1544976749, '2018-12-16 16:12:29'];
    }

    public function convertToDatabaseValueDataProvider(): \Generator
    {
        yield [new \DateTimeImmutable('1969-12-31 23:59:59'), -3601];
        yield [new \DateTimeImmutable('1970-01-01 00:00:00'), -3600];
        yield [new \DateTimeImmutable('1970-01-01 00:59:59'), -1];
        yield [new \DateTimeImmutable('1970-01-01 01:00:00'), 0];
        yield [new \DateTimeImmutable('1970-01-01 01:00:01'), 1];
        yield [new \DateTimeImmutable('2018-12-16 16:12:29'), 1544973149];
    }
}
