<?php declare(strict_types=1);

namespace BalticRobo\Api\Repository\User;

use BalticRobo\Api\Entity\User\Email;
use BalticRobo\Api\Entity\User\User;
use BalticRobo\Api\Exception\User\UserNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getUserByEmail(Email $email): User
    {
        $record = $this->findOneBy(['email.address' => $email->getAddress()]);
        if (!$record) {
            throw new UserNotFoundException();
        }

        return $record;
    }
}
