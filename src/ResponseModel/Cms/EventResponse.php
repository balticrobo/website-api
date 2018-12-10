<?php declare(strict_types=1);

namespace BalticRobo\Api\ResponseModel\Cms;

use BalticRobo\Api\Model\Cms\Event\EventDTO;
use BalticRobo\Api\ResponseModel\ResponseInterface;

final class EventResponse implements ResponseInterface
{
    private $event;

    public function __construct(EventDTO $event)
    {
        $this->event = $event;
    }

    public function respond(): array
    {
        $event = $this->event;

        return [
            'data' => [
                'event' => [
                    'year' => $event->getYear(),
                    'eventStartsAt' => $event->getEventStartsAt()->format(\DateTime::DATE_ATOM),
                    'registrationStartsAt' => $event->getRegistrationStartsAt()->format(\DateTime::DATE_ATOM),
                    'registrationStopsAt' => $event->getRegistrationStopsAt()->format(\DateTime::DATE_ATOM),
                ],
            ],
        ];
    }
}
