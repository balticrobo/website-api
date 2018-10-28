<?php declare(strict_types=1);

namespace BalticRobo\Api\Security;

use BalticRobo\Api\Entity\User\Email;
use BalticRobo\Api\Entity\User\User;
use BalticRobo\Api\Exception\User\UserNotFoundException;
use BalticRobo\Api\Repository\User\UserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class JwtProvider implements UserProviderInterface
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function loadUserByUsername($username): UserInterface
    {
        try {
            return $this->userRepository->getUserByEmail(new Email($username));
        } catch (UserNotFoundException $e) {
            throw new UsernameNotFoundException();
        }
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException();
        }

        throw new \Exception('JwtProvider::refreshUser() called');
    }

    public function supportsClass($class): bool
    {
        return User::class === $class;
    }
}
