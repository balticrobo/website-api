<?php declare(strict_types=1);

namespace BalticRobo\Api\Security;

use BalticRobo\Api\Model\User\TokenDTO;
use BalticRobo\Api\Service\User\AuthenticationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

final class TokenAuthenticator extends AbstractGuardAuthenticator
{
    private $authentication;

    public function __construct(AuthenticationService $authentication)
    {
        $this->authentication = $authentication;
    }

    public function supports(Request $request): bool
    {
        return $request->headers->has('Authorization');
    }

    public function getCredentials(Request $request): TokenDTO
    {
        $token = new TokenDTO($request->headers->get('Authorization'));
        if (!$this->authentication->isTokenCorrect($token)) {
            throw new AuthenticationException('Incorrect token.');
        }

        return $token;
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        return $this->authentication->getUserFromToken($credentials);
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(['error' => ['message' => 'Incorrect token.']], Response::HTTP_FORBIDDEN);
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new JsonResponse(['error' => ['message' => 'Token is missing.']], Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe(): bool
    {
        return false;
    }
}
