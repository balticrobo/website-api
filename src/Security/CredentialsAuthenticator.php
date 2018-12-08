<?php declare(strict_types=1);

namespace BalticRobo\Api\Security;

use BalticRobo\Api\Model\User\CredentialsDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

final class CredentialsAuthenticator extends AbstractGuardAuthenticator
{
    private $passwordEncoder;
    private $router;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, RouterInterface $router)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->router = $router;
    }

    public function supports(Request $request): bool
    {
        return $this->router->generate('balticrobo_api_security_createtoken') === $request->getRequestUri()
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request): CredentialsDTO
    {
        if (!$request->request->has('email') || !$request->request->has('password')) {
            throw new AuthenticationException('Incorrect request.');
        }

        return new CredentialsDTO($request->request->get('email'), $request->request->get('password'));
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        return $userProvider->loadUserByUsername($credentials->getEmail());
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials->getPassword());
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(['error' => ['message' => 'Invalid credentials.']], Response::HTTP_FORBIDDEN);
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new JsonResponse(['error' => ['message' => 'It shouldn\'t happen.']], Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe(): bool
    {
        return false;
    }
}
