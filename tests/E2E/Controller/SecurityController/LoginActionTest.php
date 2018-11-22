<?php declare(strict_types=1);

namespace BalticRobo\Api\Tests\E2E\Controller\SecurityController;

use BalticRobo\Api\Entity\User\Email;
use BalticRobo\Api\Entity\User\Roles;
use BalticRobo\Api\Entity\User\User;
use BalticRobo\Api\Model\User\UserDTO;
use BalticRobo\Api\Tests\E2E\WebTestCase;
use PHPUnit\Framework\Assert;

/**
 * @coversNothing
 */
class LoginActionTest extends WebTestCase
{
    /**
     * @test
     */
    public function itReturnsJWTWhileCredentialsAreCorrect(): void
    {
        $this->createUser('jdoe@example.com', '123', true);
        $payload = json_encode([
            'email' => 'jdoe@example.com',
            'password' => '123',
        ]);
        $this->client->request('POST', '/login', [], [], ['CONTENT_TYPE' => 'application/json'], $payload);

        $jwtPayload = json_decode(base64_decode(json_decode($this->client->getResponse()->getContent())->data->token));
        Assert::assertSame(200, $this->client->getResponse()->getStatusCode());
        Assert::assertSame('https://api.bbr.local', $jwtPayload->iss);
        Assert::assertSame(1, $jwtPayload->idx);
        Assert::assertSame('jdoe@example.com', $jwtPayload->ema);
        Assert::assertSame(3600, $jwtPayload->exp - $jwtPayload->iat);
    }

    /**
     * @test
     */
    public function itReturnsInvalidCredentialsWhileCredentialsAreIncorrect(): void
    {
        $this->createUser('jdoe@example.com', '123', true);
        $payload = json_encode([
            'email' => 'jdoe@example.com',
            'password' => 'wrong',
        ]);
        $this->client->request('POST', '/login', [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
        $response = json_decode($this->client->getResponse()->getContent());

        Assert::assertSame(403, $this->client->getResponse()->getStatusCode());
        Assert::assertSame('Invalid credentials.', $response->error->message);
    }

    /**
     * @test
     */
    public function itReturnsInvalidCredentialsWhileUserNotExists(): void
    {
        $payload = json_encode([
            'email' => 'jdoe@example.com',
            'password' => '123',
        ]);
        $this->client->request('POST', '/login', [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
        $response = json_decode($this->client->getResponse()->getContent());

        Assert::assertSame(403, $this->client->getResponse()->getStatusCode());
        Assert::assertSame('Invalid credentials.', $response->error->message);
    }

    /**
     * @test
     */
    public function itReturnsInvalidCredentialsWhilePayloadIsIncorrect(): void
    {
        $this->createUser('jdoe@example.com', '123', true);
        $payload = json_encode([
            'e' => 'jdoe@example.com',
            'p' => 'wrong',
        ]);
        $this->client->request('POST', '/login', [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
        $response = json_decode($this->client->getResponse()->getContent());

        Assert::assertSame(403, $this->client->getResponse()->getStatusCode());
        Assert::assertSame('Invalid credentials.', $response->error->message);
    }

    private function createUser(string $email, string $password, bool $isActive): void
    {
        $dto = new UserDTO('John', 'Doe', new Email($email), new Roles(['ROLE_USER']));
        $dto->setActive($isActive);
        $user = User::createFromDTO($dto, new \DateTimeImmutable());
        $user->setPassword($this->getContainer()->get('security.password_encoder')->encodePassword($user, $password));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
