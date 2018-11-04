<?php declare(strict_types=1);

namespace BalticRobo\Api\Model\User;

final class TokenDTO
{
    private const BEARER_LENGTH = 7;

    private $token;

    public function __construct(string $token)
    {
        $this->token = $this->removeBearerPrefix($token);
    }

    public function getToken(): string
    {

        return $this->token;
    }

    private function removeBearerPrefix(string $token): string
    {
        if (strpos($token, 'Bearer') !== false) {
            return substr($token, self::BEARER_LENGTH);
        }

        return $token;
    }
}
