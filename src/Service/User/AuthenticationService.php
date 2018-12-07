<?php declare(strict_types=1);

namespace BalticRobo\Api\Service\User;

use BalticRobo\Api\Entity\User\User;
use BalticRobo\Api\Model\User\TokenDataDTO;
use BalticRobo\Api\Model\User\TokenDTO;
use BalticRobo\Api\Service\User\Jwt\JwtAuthInterface;

final class AuthenticationService
{
    private $jwtAuth;

    public function __construct(JwtAuthInterface $jwtAuth)
    {
        $this->jwtAuth = $jwtAuth;
    }

    public function createToken(TokenDataDTO $dto): TokenDTO
    {
        return $this->jwtAuth->encode($dto);
    }

    public function refreshToken(TokenDTO $dto, \DateTimeImmutable $now): TokenDTO
    {
        $oldData = $this->jwtAuth->decodeToRefresh($dto);
        $newData = TokenDataDTO::createFromOldTokenDataDTO($oldData, $now);

        return $this->createToken($newData);
    }

    public function isTokenCorrect(TokenDTO $dto): bool
    {
        return $this->jwtAuth->verify($dto);
    }

    public function getUserFromToken(TokenDTO $dto): User
    {
        $data = $this->jwtAuth->decode($dto);

        return $data->getUser();
    }
}
