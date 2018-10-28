<?php declare(strict_types=1);

namespace BalticRobo\Api\Exception\User;

use BalticRobo\Api\Exception\NotFoundExceptionInterface;

final class UserNotFoundException extends \DomainException implements NotFoundExceptionInterface
{
    public function __construct()
    {
        parent::__construct('User not found.');
    }
}
