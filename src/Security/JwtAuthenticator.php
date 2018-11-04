<?php declare(strict_types=1);

namespace BalticRobo\Api\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

/**
 * TODO: Create authenticator
 * @see https://symfony.com/doc/current/security/guard_authentication.html
 */
final class JwtAuthenticator extends AbstractGuardAuthenticator
{
    public function supports(Request $request): bool
    {
        return $request->headers->has('Authorization');
    }

    public function getCredentials(Request $request): array { }

    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface { }

    public function checkCredentials($credentials, UserInterface $user): bool { }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response { }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): ?Response { }

    public function start(Request $request, AuthenticationException $authException = null): Response { }

    public function supportsRememberMe(): bool
    {
        return false;
    }
}
