<?php declare(strict_types=1);

namespace BalticRobo\Api\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class RequestValidatorValidationFailed extends \RuntimeException
{
    private $violations;

    public function __construct(ConstraintViolationListInterface $violations)
    {
        parent::__construct('Validation failed.');
        $this->violations = $violations;
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
