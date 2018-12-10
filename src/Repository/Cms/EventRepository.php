<?php declare(strict_types=1);

namespace BalticRobo\Api\Repository\Cms;

use BalticRobo\Api\Entity\Cms\Event\Event;
use BalticRobo\Api\Exception\Cms\Event\EventNotFoundException;
use Doctrine\Common\Persistence\ObjectManager;

class EventRepository
{
    private $objectManager;
    private $repository;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->repository = $objectManager->getRepository(Event::class);
    }

    public function getEventByYear(int $year): Event
    {
        $record = $this->repository->findOneBy(['year' => $year]);
        if (!$record) {
            throw new EventNotFoundException();
        }

        return $record;
    }

    public function save(Event $event): void
    {
        $this->objectManager->persist($event);
        $this->objectManager->flush();
    }
}
