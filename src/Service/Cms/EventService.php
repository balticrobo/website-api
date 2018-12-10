<?php declare(strict_types=1);

namespace BalticRobo\Api\Service\Cms;

use BalticRobo\Api\Entity\Cms\Event\Event;
use BalticRobo\Api\Model\Cms\Event\EventDTO;
use BalticRobo\Api\Repository\Cms\EventRepository;

final class EventService
{
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function create(EventDTO $dto): Event
    {
        $event = Event::createFromDTO(($dto));
        $this->eventRepository->save($event);

        return $event;
    }
}
