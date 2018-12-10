<?php declare(strict_types=1);

namespace BalticRobo\Api\Entity\Cms\Event;

use BalticRobo\Api\Model\Cms\Event\EventDTO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="events")
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $year;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $eventStartsAt;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $registrationStartsAt;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $registrationStopsAt;

    public static function createFromDTO(EventDTO $dto): self
    {
        $entity = new self();

        $entity->year = $dto->getYear();
        $entity->eventStartsAt = $dto->getEventStartsAt();
        $entity->registrationStartsAt = $dto->getRegistrationStartsAt();
        $entity->registrationStopsAt = $dto->getRegistrationStopsAt();

        return $entity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getEventStartsAt(): \DateTimeImmutable
    {
        return $this->eventStartsAt;
    }

    public function getRegistrationStartsAt(): \DateTimeImmutable
    {
        return $this->registrationStartsAt;
    }

    public function getRegistrationStopsAt(): \DateTimeImmutable
    {
        return $this->registrationStopsAt;
    }
}
