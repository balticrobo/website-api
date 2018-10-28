<?php declare(strict_types=1);

namespace BalticRobo\Api\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;

final class UserLoginSubscriber implements EventSubscriberInterface
{
    public function onSecurityAuthenticationSuccess(AuthenticationEvent $event)
    {
        // ...
    }

    public static function getSubscribedEvents()
    {
        return [
           'security.authentication.success' => 'onSecurityAuthenticationSuccess',
        ];
    }
}
