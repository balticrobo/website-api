<?php declare(strict_types=1);

namespace BalticRobo\Api\Service\User\Jwt;

use BalticRobo\Api\Exception\JWTExpiredException;
use BalticRobo\Api\Model\User\TokenDataDTO;
use BalticRobo\Api\Model\User\TokenDTO;

final class NullJwtAuth implements JwtAuthInterface
{
    private $timestamp;
    private $refresh = false;

    public function __construct(int $timestamp = 0)
    {
        $this->timestamp = $timestamp;
    }

    public function encode(TokenDataDTO $dto): TokenDTO
    {
        return new TokenDTO(base64_encode(json_encode($dto->getPayload())));
    }

    public function decode(TokenDTO $dto): TokenDataDTO
    {
        $jwt = json_decode(base64_decode($dto->getToken()));
        if (null === $jwt) {
            throw new \UnexpectedValueException('Invalid JSON.');
        }

        if (!isset($jwt->iss, $jwt->idx, $jwt->ema, $jwt->rol, $jwt->iat, $jwt->exp)) {
            throw new \DomainException('Invalid JWT.');
        } elseif ($this->timestamp < $jwt->iat) {
            throw new \DomainException('Token will begin later.');
        } elseif ($this->timestamp >= $jwt->exp
            || (($this->timestamp + TokenDataDTO::TOKEN_REFRESH_TIME) >= $jwt->exp && $this->refresh)) {
            throw new \DomainException('Token expired.');
        }

        return TokenDataDTO::createFromJWT($jwt);
    }

    public function decodeToRefresh(TokenDTO $dto): TokenDataDTO
    {
        $this->refresh = true;
        try {
            return $this->decode($dto);
        } catch (\DomainException $e) {
            throw new JWTExpiredException();
        }
    }

    public function verify(TokenDTO $dto): bool
    {
        try {
            $this->decode($dto);
        } catch (\UnexpectedValueException | \DomainException $e) {
            return false;
        }

        return true;
    }
}
