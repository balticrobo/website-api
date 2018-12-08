<?php declare(strict_types=1);

namespace BalticRobo\Api\Service\User\Jwt;

use BalticRobo\Api\Exception\JWTExpiredException;
use BalticRobo\Api\Model\User\TokenDataDTO;
use BalticRobo\Api\Model\User\TokenDTO;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;

final class FirebaseJwtAuth implements JwtAuthInterface
{
    private $secret;
    private $algorithm;

    public function __construct(string $secret, string $algorithm)
    {
        $this->secret = $secret;
        $this->algorithm = $algorithm;
    }

    public function encode(TokenDataDTO $dto): TokenDTO
    {
        return new TokenDTO(JWT::encode($dto->getPayload(), $this->secret, $this->algorithm));
    }

    public function decode(TokenDTO $dto): TokenDataDTO
    {
        return TokenDataDTO::createFromJWT(JWT::decode($dto->getToken(), $this->secret, [$this->algorithm]));
    }

    public function decodeToRefresh(TokenDTO $dto): TokenDataDTO
    {
        JWT::$leeway = TokenDataDTO::TOKEN_REFRESH_TIME;
        try {
            return $this->decode($dto);
        } catch (ExpiredException $e) {
            throw new JWTExpiredException();
        }
    }

    public function verify(TokenDTO $dto): bool
    {
        try {
            JWT::decode($dto->getToken(), $this->secret, [$this->algorithm]);
        } catch (SignatureInvalidException | BeforeValidException | ExpiredException $e) {
            return false;
        }

        return true;
    }
}
