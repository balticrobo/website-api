<?php declare(strict_types=1);

namespace BalticRobo\Api\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class JwtAuthenticator extends AbstractGuardAuthenticator
{
    public function supports(Request $request)
    {
        // todo
    }

    public function getCredentials(Request $request)
    {
        // todo
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // todo
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // todo
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // todo
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // todo
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        // todo
    }

    public function supportsRememberMe()
    {
        // todo
    }
}
