<?php declare(strict_types=1);

namespace BalticRobo\Api\RequestValidator\Security;

use BalticRobo\Api\Model\User\TokenDTO;
use BalticRobo\Api\RequestValidator\RequestValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class RefreshTokenRequestHandler implements RequestValidatorInterface
{
    public function getRules(): Assert\Collection
    {
        return new Assert\Collection([
            'token' => [
                new Assert\NotBlank(),
            ],
        ]);
    }

    public function prepareModel(array $data): object
    {
        return new TokenDTO($data['token']);
    }
}
