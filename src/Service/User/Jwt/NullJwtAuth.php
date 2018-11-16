<?php declare(strict_types=1);

namespace BalticRobo\Api\Service\User\Jwt;

use BalticRobo\Api\Model\User\TokenDataDTO;
use BalticRobo\Api\Model\User\TokenDTO;

final class NullJwtAuth implements JwtAuthInterface
{
    public function encode(TokenDataDTO $dto): TokenDTO
    {
        $segments = [
            self::urlsafeB64Encode('{"typ":"JWT","alg":"none"}'),
            self::urlsafeB64Encode(json_encode($dto->getPayload())),
        ];

        return new TokenDTO(implode('.', $segments));
    }

    public function decode(TokenDTO $dto): TokenDataDTO
    {
        // TODO: Implement decode() method
    }

    public function verify(TokenDTO $dto): bool
    {
        // TODO: Implement verify() method
    }

    private static function urlsafeB64Encode($input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }
}
