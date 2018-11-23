<?php declare(strict_types=1);

namespace BalticRobo\Api\Event;

use BalticRobo\Api\Service\User\ManageUserService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

final class UserLoginSubscriber implements EventSubscriberInterface
{
    private $router;
    private $userService;

    public function __construct(RouterInterface $router, ManageUserService $userService)
    {
        $this->router = $router;
        $this->userService = $userService;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event): void
    {
        $request = $event->getRequest();
        if ($this->router->generate('balticrobo_api_security_login') === $request->getRequestUri()) {
            $user = $event->getAuthenticationToken()->getUser();
            $user->setLastLoginAt(new \DateTimeImmutable());
            $this->userService->update($user);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin',
        ];
    }
}
