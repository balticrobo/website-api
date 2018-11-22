<?php declare(strict_types=1);

namespace BalticRobo\Api\Service\User;

use BalticRobo\Api\Entity\User\User;
use BalticRobo\Api\Model\User\UserDTO;
use BalticRobo\Api\Repository\User\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class ManageUserService
{
    private $userRepository;
    private $passwordEncoder;

    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function create(UserDTO $dto, \DateTimeImmutable $time): User
    {
        $user = User::createFromDTO($dto, $time);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
        $this->userRepository->save($user);

        return $user;
    }
}
