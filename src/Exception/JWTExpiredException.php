<?php declare(strict_types=1);

namespace BalticRobo\Api\Exception;

class JWTExpiredException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Token expired.');
    }
}
