<?php declare(strict_types=1);
namespace BalticRobo\Api\ResponseModel\Error;

use BalticRobo\Api\Exception\JWTExpiredException;
use BalticRobo\Api\ResponseModel\ResponseInterface;

final class TokenExpiredResponse implements ResponseInterface
{
    private $exception;

    public function __construct(JWTExpiredException $exception)
    {
        $this->exception = $exception;
    }

    public function respond(): array
    {
        return [
            'error' => [
                'message' => 'Validation failed.',
                'violations' => [
                    'token' => [
                        $this->exception->getMessage(),
                    ],
                ],
            ],
        ];
    }
}
