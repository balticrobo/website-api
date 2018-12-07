<?php declare(strict_types=1);

namespace BalticRobo\Api\RequestValidator;

use Symfony\Component\Validator\Constraints\Collection;

interface RequestValidatorInterface
{
    public function getRules(): Collection;
    public function prepareModel(array $data): object;
}
