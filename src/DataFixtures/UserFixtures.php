<?php declare(strict_types=1);

namespace BalticRobo\Api\DataFixtures;

use BalticRobo\Api\Entity\User\Email;
use BalticRobo\Api\Entity\User\Roles;
use BalticRobo\Api\Entity\User\User;
use BalticRobo\Api\Model\User\UserDTO;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserFixtures extends Fixture
{
    private const DEFAULT_PASSWORD = 'test';

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $dto = new UserDTO('John', 'Doe', new Email('jdoe@example.com'), new Roles(['ROLE_USER', 'ROLE_ADMIN']));
        $dto->setActive();
        $user = User::createFromDTO($dto, new \DateTimeImmutable('@0'));
        $user->setPassword($this->passwordEncoder->encodePassword($user, self::DEFAULT_PASSWORD));
        $manager->persist($user);
        $manager->flush();
    }
}
