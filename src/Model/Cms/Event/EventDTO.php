<?php declare(strict_types=1);

namespace BalticRobo\Api\Model\Cms\Event;

final class EventDTO
{
    private $year;
    private $eventStartsAt;
    private $registrationStartsAt;
    private $registrationStopsAt;

    public function __construct(
        int $year,
        \DateTimeImmutable $eventStartsAt,
        \DateTimeImmutable $registrationStartsAt,
        \DateTimeImmutable $registrationStopsAt
    ) {
        $this->year = $year;
        $this->eventStartsAt = $eventStartsAt;
        $this->registrationStartsAt = $registrationStartsAt;
        $this->registrationStopsAt = $registrationStopsAt;
    }

    public static function createFromArray(array $data): self
    {
        return new self(
            $data['year'],
            new \DateTimeImmutable($data['eventStartsAt']),
            new \DateTimeImmutable($data['registrationStartsAt']),
            new \DateTimeImmutable($data['registrationStopsAt'])
        );
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
