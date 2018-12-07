<?php declare(strict_types=1);

namespace BalticRobo\Api\Model\User;

use BalticRobo\Api\Entity\User\User;
use Symfony\Component\HttpFoundation\Request;

final class TokenDataDTO
{
    public const TOKEN_REFRESH_TIME = 259200; // 72h
    private const TOKEN_LIVE_TIME = 3600; // 1h

    private $address;
    private $user;
    private $issuedAt;
    private $expiresAt;

    private function __construct()
    {
    }

    public static function createFromRequestUserAndTime(Request $request, User $user, \DateTimeImmutable $now): self
    {
        $dto = new self();
        $dto->address = $request->getSchemeAndHttpHost();
        $dto->user = $user;
        $dto->issuedAt = $now;
        $dto->expiresAt = $now->add(new \DateInterval('PT' . self::TOKEN_LIVE_TIME . 'S'));

        return $dto;
    }

    public static function createFromOldTokenDataDTO(self $oldDto, \DateTimeImmutable $now): self
    {
        $dto = new self();
        $dto->address = $oldDto->getAddress();
        $dto->user = $oldDto->getUser();
        $dto->issuedAt = $now;
        $dto->expiresAt = $now->add(new \DateInterval('PT' . self::TOKEN_LIVE_TIME . 'S'));

        return $dto;
    }

    public static function createFromJWT(\stdClass $jwt): self
    {
        $dto = new self();
        $dto->address = $jwt->iss;
        $dto->user = User::createFromIdEmailRoles($jwt->idx, $jwt->ema, $jwt->rol);
        $dto->issuedAt = new \DateTimeImmutable("@{$jwt->iat}");
        $dto->expiresAt = new \DateTimeImmutable("@{$jwt->exp}");

        return $dto;
    }

    public function getPayload(): array
    {
        return [
            'iss' => $this->address,
            'iat' => $this->issuedAt->getTimestamp(),
            'exp' => $this->expiresAt->getTimestamp(),
            'idx' => $this->user->getId(),
            'ema' => $this->user->getEmailAddress(),
            'rol' => $this->user->getRoles(),
        ];
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
