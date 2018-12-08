<?php declare(strict_types=1);

namespace BalticRobo\Api\ResponseModel;

interface ResponseInterface
{
    public function respond(): array;
}
