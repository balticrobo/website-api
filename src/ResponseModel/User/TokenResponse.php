<?php declare(strict_types=1);

namespace BalticRobo\Api\ResponseModel\User;

use BalticRobo\Api\Model\User\TokenDTO;
use BalticRobo\Api\ResponseModel\ResponseInterface;

final class TokenResponse implements ResponseInterface
{
    private $token;

    public function __construct(TokenDTO $token)
    {
        $this->token = $token;
    }

    public function respond(): array
    {
        return [
            'data' => [
                'token' => $this->token->getToken(),
            ],
        ];
    }
}
