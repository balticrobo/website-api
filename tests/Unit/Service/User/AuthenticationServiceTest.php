<?php declare(strict_types=1);
namespace BalticRobo\Api\Tests\Unit\Service\User;

use BalticRobo\Api\Entity\User\User;
use BalticRobo\Api\Model\User\TokenDataDTO;
use BalticRobo\Api\Service\User\AuthenticationService;
use BalticRobo\Api\Service\User\Jwt\NullJwtAuth;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

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
     * @test
     * @dataProvider createTokenDataProvider
     */
    public function createToken(User $user, int $timestamp, string $token): void
    {
        $time = new \DateTimeImmutable("@{$timestamp}");
        $dto = TokenDataDTO::createFromRequestUserAndTime($this->request, $user, $time);

        $service = new AuthenticationService(new NullJwtAuth());
        $jwt = $service->createToken($dto);

        Assert::assertSame($token, $jwt->getToken());
    }

    public function createTokenDataProvider(): \Generator
    {
        yield 'User with ID 1' => [
            User::createFromIdEmailRoles(1, 'jdoe@example.com', ['ROLE_SUPERADMIN']),
            0,
            'eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIn0.eyJpc3MiOiJodHRwczpcL1wvYXBpLmJici5sb2NhbDo4MDAwIiwiaWF0IjowLCJleHAiOj'
            . 'M2MDAsImlkeCI6MSwiZW1hIjoiamRvZUBleGFtcGxlLmNvbSIsInJvbCI6WyJST0xFX1NVUEVSQURNSU4iLCJST0xFX1VTRVIiXX0',
        ];
        yield 'User with ID 2' => [
            User::createFromIdEmailRoles(2, 'jdoe@example.com', ['ROLE_JUDGE']),
            0,
            'eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIn0.eyJpc3MiOiJodHRwczpcL1wvYXBpLmJici5sb2NhbDo4MDAwIiwiaWF0IjowLCJleHAiOj'
            . 'M2MDAsImlkeCI6MiwiZW1hIjoiamRvZUBleGFtcGxlLmNvbSIsInJvbCI6WyJST0xFX0pVREdFIiwiUk9MRV9VU0VSIl19',
        ];
        yield 'User with ID 3' => [
            User::createFromIdEmailRoles(3, 'jane@example.com', ['ROLE_USER']),
            1543210123,
            'eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIn0.eyJpc3MiOiJodHRwczpcL1wvYXBpLmJici5sb2NhbDo4MDAwIiwiaWF0IjoxNTQzMjEwMT'
            . 'IzLCJleHAiOjE1NDMyMTM3MjMsImlkeCI6MywiZW1hIjoiamFuZUBleGFtcGxlLmNvbSIsInJvbCI6WyJST0xFX1VTRVIiXX0',
        ];
        yield 'User with ID 4' => [
            User::createFromIdEmailRoles(4, 'sample@example.com', ['ROLE_USER', 'ROLE_ONE', 'ROLE_TWO', 'ROLE_THREE']),
            1543210987,
            'eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIn0.eyJpc3MiOiJodHRwczpcL1wvYXBpLmJici5sb2NhbDo4MDAwIiwiaWF0IjoxNTQzMjEwOT'
            . 'g3LCJleHAiOjE1NDMyMTQ1ODcsImlkeCI6NCwiZW1hIjoic2FtcGxlQGV4YW1wbGUuY29tIiwicm9sIjpbIlJPTEVfVVNFUiIsIlJPTE'
            . 'VfT05FIiwiUk9MRV9UV08iLCJST0xFX1RIUkVFIl19',
        ];
    }
}
