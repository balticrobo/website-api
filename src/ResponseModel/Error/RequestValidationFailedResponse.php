<?php declare(strict_types=1);

namespace BalticRobo\Api\ResponseModel\Error;

use BalticRobo\Api\Exception\RequestValidatorValidationFailed;
use BalticRobo\Api\ResponseModel\ResponseInterface;

final class RequestValidationFailedResponse implements ResponseInterface
{
    private $exception;
    private $violations;

    public function __construct(RequestValidatorValidationFailed $exception, array $violations)
    {
        $this->exception = $exception;
        $this->violations = $violations;
    }

    public function respond(): array
    {
        return [
            'error' => [
                'message' => $this->exception->getMessage(),
                'violations' => $this->violations,
            ],
        ];
    }
}
