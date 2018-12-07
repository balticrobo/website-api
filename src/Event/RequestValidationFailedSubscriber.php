<?php declare(strict_types=1);

namespace BalticRobo\Api\Event;

use BalticRobo\Api\Exception\RequestValidatorValidationFailed;
use BalticRobo\Api\ResponseModel\Error\RequestValidationFailedResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class RequestValidationFailedSubscriber implements EventSubscriberInterface
{
    private $propertyAccessor;

    public function __construct(PropertyAccessorInterface $propertyAccessor)
    {
        $this->propertyAccessor = $propertyAccessor;
    }

    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();
        if (!$exception instanceof RequestValidatorValidationFailed) {
            return;
        }
        $errors = $this->prepareReadableViolationList($exception->getViolations());
        $event->setResponse(new JsonResponse(
            (new RequestValidationFailedResponse($exception, $errors))->respond(),
            Response::HTTP_UNPROCESSABLE_ENTITY
        ));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    private function prepareReadableViolationList(ConstraintViolationListInterface $violationList): array
    {
        $errors = [];
        foreach ($violationList as $violation) {
            $entryErrors = (array)$this->propertyAccessor->getValue($errors, $violation->getPropertyPath());
            $entryErrors[] = $violation->getMessage();
            $this->propertyAccessor->setValue($errors, $violation->getPropertyPath(), $entryErrors);
        }

        return $errors;
    }
}
