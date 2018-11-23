<?php declare(strict_types=1);

namespace BalticRobo\Api\Repository\User;

use BalticRobo\Api\Entity\User\Email;
use BalticRobo\Api\Entity\User\User;
use BalticRobo\Api\Exception\User\UserNotFoundException;
use Doctrine\Common\Persistence\ObjectManager;

class UserRepository
{
    private $objectManager;
    private $repository;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->repository = $objectManager->getRepository(User::class);
    }

    public function getUserByEmail(Email $email): User
    {
        $record = $this->repository->findOneBy(['email.address' => $email->getAddress()]);
        if (!$record) {
            throw new UserNotFoundException();
        }

        return $record;
    }

    public function save(User $user): void
    {
        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }
}
