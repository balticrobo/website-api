<?php declare(strict_types=1);

namespace BalticRobo\Api\RequestValidator;

use BalticRobo\Api\Exception\RequestValidatorValidationFailed;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RequestHandler
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function handle(Request $request, RequestValidatorInterface $requestValidator): object
    {
        $data = $request->request->all();
        $violations = $this->validator->validate($data, $requestValidator->getRules());
        if ($violations->count()) {
            throw new RequestValidatorValidationFailed($violations);
        }
        return $requestValidator->prepareModel($data);
    }
}
