<?php declare(strict_types=1);
namespace BalticRobo\Api\Tests\Unit\Service\User;

use BalticRobo\Api\Entity\User\User;
use BalticRobo\Api\Model\User\TokenDataDTO;
use BalticRobo\Api\Model\User\TokenDTO;
use BalticRobo\Api\Service\User\AuthenticationService;
use BalticRobo\Api\Service\User\Jwt\NullJwtAuth;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @covers \BalticRobo\Api\Service\User\AuthenticationService
 */
class AuthenticationServiceTest extends TestCase
{
    private $request;

    public function setUp(): void
    {
        $this->request = new Request([], [], [], [], [], [
            'HTTPS' => true,
            'SERVER_PORT' => '8000',
            'SERVER_NAME' => 'api.bbr.local',
        ]);
    }

    public function tearDown(): void
    {
        $this->request = null;
    }

    /**
     * @dataProvider encodeDecodeTokenDataProvider
     */
    public function testCreateToken(User $user, \DateTimeImmutable $time, string $token): void
    {
        $dto = TokenDataDTO::createFromRequestUserAndTime($this->request, $user, $time);

        $service = new AuthenticationService(new NullJwtAuth());
        $jwt = $service->createToken($dto);

        Assert::assertSame($token, $jwt->getToken());
    }

    /**
     * @dataProvider verifyTokenDataProvider
     */
    public function testIsTokenCorrect(string $token, bool $expectedResult, \DateTimeImmutable $actualTime): void
    {
        $dto = new TokenDTO($token);

        $service = new AuthenticationService(new NullJwtAuth($actualTime->getTimestamp()));
        $result = $service->isTokenCorrect($dto);

        Assert::assertSame($expectedResult, $result);
    }

    /**
     * @dataProvider encodeDecodeTokenDataProvider
     */
    public function testGetUserFromToken(User $expectedUser, \DateTimeImmutable $actualTime, string $token): void
    {
        $dto = new TokenDTO($token);

        $service = new AuthenticationService(new NullJwtAuth($actualTime->getTimestamp()));
        $user = $service->getUserFromToken($dto);

        Assert::assertTrue($expectedUser->isEqualTo($user));
    }

    public function encodeDecodeTokenDataProvider(): \Generator
    {
        yield 'User with ID 1' => [
            User::createFromIdEmailRoles(1, 'jdoe@example.com', ['ROLE_SUPERADMIN']),
            new \DateTimeImmutable("@0"),
            'eyJpc3MiOiJodHRwczpcL1wvYXBpLmJici5sb2NhbDo4MDAwIiwiaWF0IjowLCJleHAiOjM2MDAsImlkeCI6MSwiZW1hIjoiamRvZUBleG'
            . 'FtcGxlLmNvbSIsInJvbCI6WyJST0xFX1NVUEVSQURNSU4iLCJST0xFX1VTRVIiXX0=',
        ];
        yield 'User with ID 2' => [
            User::createFromIdEmailRoles(2, 'jdoe@example.com', ['ROLE_JUDGE']),
            new \DateTimeImmutable("@0"),
            'eyJpc3MiOiJodHRwczpcL1wvYXBpLmJici5sb2NhbDo4MDAwIiwiaWF0IjowLCJleHAiOjM2MDAsImlkeCI6MiwiZW1hIjoiamRvZUBleG'
            . 'FtcGxlLmNvbSIsInJvbCI6WyJST0xFX0pVREdFIiwiUk9MRV9VU0VSIl19',
        ];
        yield 'User with ID 3' => [
            User::createFromIdEmailRoles(3, 'jane@example.com', ['ROLE_USER']),
            new \DateTimeImmutable("@1543210123"),
            'eyJpc3MiOiJodHRwczpcL1wvYXBpLmJici5sb2NhbDo4MDAwIiwiaWF0IjoxNTQzMjEwMTIzLCJleHAiOjE1NDMyMTM3MjMsImlkeCI6My'
            . 'wiZW1hIjoiamFuZUBleGFtcGxlLmNvbSIsInJvbCI6WyJST0xFX1VTRVIiXX0=',
        ];
        yield 'User with ID 4' => [
            User::createFromIdEmailRoles(4, 'sample@example.com', ['ROLE_USER', 'ROLE_ONE', 'ROLE_TWO', 'ROLE_THREE']),
            new \DateTimeImmutable("@1543210987"),
            'eyJpc3MiOiJodHRwczpcL1wvYXBpLmJici5sb2NhbDo4MDAwIiwiaWF0IjoxNTQzMjEwOTg3LCJleHAiOjE1NDMyMTQ1ODcsImlkeCI6NC'
            . 'wiZW1hIjoic2FtcGxlQGV4YW1wbGUuY29tIiwicm9sIjpbIlJPTEVfVVNFUiIsIlJPTEVfT05FIiwiUk9MRV9UV08iLCJST0xFX1RIUk'
            . 'VFIl19',
        ];
    }

    public function verifyTokenDataProvider(): \Generator
    {
        yield 'Correct token #1' => [
            'eyJpc3MiOiJodHRwczpcL1wvYXBpLmJici5sb2NhbDo4MDAwIiwiaWF0IjowLCJleHAiOjM2MDAsImlkeCI6MSwiZW1hIjoiamRvZUBleG'
            . 'FtcGxlLmNvbSIsInJvbCI6WyJST0xFX1NVUEVSQURNSU4iLCJST0xFX1VTRVIiXX0=',
            true,
            new \DateTimeImmutable("@0"),
        ];
        yield 'Incorrect token #1 (too early)' => [
            'eyJpc3MiOiJodHRwczpcL1wvYXBpLmJici5sb2NhbDo4MDAwIiwiaWF0IjowLCJleHAiOjM2MDAsImlkeCI6MSwiZW1hIjoiamRvZUBleG'
            . 'FtcGxlLmNvbSIsInJvbCI6WyJST0xFX1NVUEVSQURNSU4iLCJST0xFX1VTRVIiXX0=',
            false,
            new \DateTimeImmutable("@1543210123"),
        ];
        yield 'Correct token #2' => [
            'eyJpc3MiOiJodHRwczpcL1wvYXBpLmJici5sb2NhbDo4MDAwIiwiaWF0IjoxNTQzMjEwMTIzLCJleHAiOjE1NDMyMTM3MjMsImlkeCI6My'
            . 'wiZW1hIjoiamFuZUBleGFtcGxlLmNvbSIsInJvbCI6WyJST0xFX1VTRVIiXX0=',
            true,
            new \DateTimeImmutable("@1543210123"),
        ];
        yield 'Incorrect token #2 (expired)' => [
            'eyJpc3MiOiJodHRwczpcL1wvYXBpLmJici5sb2NhbDo4MDAwIiwiaWF0IjoxNTQzMjEwMTIzLCJleHAiOjE1NDMyMTM3MjMsImlkeCI6My'
            . 'wiZW1hIjoiamFuZUBleGFtcGxlLmNvbSIsInJvbCI6WyJST0xFX1VTRVIiXX0=',
            false,
            new \DateTimeImmutable("@0"),
        ];
        yield 'Incorrect token #3 (invalid json)' => [
            '',
            false,
            new \DateTimeImmutable("@0"),
        ];
        yield 'Incorrect token #4 (invalid json)' => [
            'abcdabcd',
            false,
            new \DateTimeImmutable("@0"),
        ];
        yield 'Incorrect token #5 (invalid json)' => [
            'eyJlbWFpbCI6Impkb2VAZXhhbXBsZS5jb20iLCJwYXNzd29yZCI6IjEyMyJ9',
            false,
            new \DateTimeImmutable("@0"),
        ];
    }
}
