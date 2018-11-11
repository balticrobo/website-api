<?php declare(strict_types=1);

namespace BalticRobo\Api\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;

final class UserLoginSubscriber implements EventSubscriberInterface
{
    /**
     * TODO: Add last login at
     */
    public function onSecurityAuthenticationSuccess(AuthenticationEvent $event): void
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AuthenticationEvents::AUTHENTICATION_SUCCESS => 'onSecurityAuthenticationSuccess',
        ];
    }
}
