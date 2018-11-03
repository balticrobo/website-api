<?php declare(strict_types=1);

namespace BalticRobo\Api\Exception\User;

final class IncorrectEmailException extends \DomainException
{
    public function __construct(string $email)
    {
        parent::__construct(sprintf('"%s" is not a valid email.', $email));
    }
}
