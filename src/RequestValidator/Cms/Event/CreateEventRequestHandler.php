<?php declare(strict_types=1);

namespace BalticRobo\Api\RequestValidator\Cms\Event;

use BalticRobo\Api\Model\Cms\Event\EventDTO;
use BalticRobo\Api\RequestValidator\RequestValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateEventRequestHandler implements RequestValidatorInterface
{
    public function getRules(): Assert\Collection
    {
        return new Assert\Collection([
            'year' => [
                new Assert\NotBlank(),
            ],
            'eventStartsAt' => [
                new Assert\NotBlank(),
            ],
            'registrationStartsAt' => [
                new Assert\NotBlank(),
            ],
            'registrationStopsAt' => [
                new Assert\NotBlank(),
            ],
        ]);
    }

    public function prepareModel(array $data): object
    {
        return EventDTO::createFromArray($data);
    }
}
