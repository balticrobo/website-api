<?php declare(strict_types=1);

namespace BalticRobo\Api\Exception;

class DoctrineTypeConversionError extends \UnexpectedValueException
{
    public function __construct()
    {
        parent::__construct('Type conversion error.');
    }
}
