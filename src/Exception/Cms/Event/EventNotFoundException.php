<?php declare(strict_types=1);

namespace BalticRobo\Api\Exception\Cms\Event;

use BalticRobo\Api\Exception\NotFoundExceptionInterface;

final class EventNotFoundException extends \DomainException implements NotFoundExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Event not found.');
    }
}
