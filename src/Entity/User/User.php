<?php declare(strict_types=1);

namespace BalticRobo\Api\Entity\User;

use BalticRobo\Api\Model\User\UserDTO;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User implements UserInterface, EquatableInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $forename;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $surname;

    /**
     * @ORM\Embedded(class="Email")
     * @var Email
     */
    private $email;

    /**
     * @ORM\Embedded(class="Roles", columnPrefix=false)
     * @var Roles
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=95)
     */
    private $password;
    private $plainPassword;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active = false;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $createdAt;

    public static function createFromIdEmailRoles(int $id, string $email, array $roles): self
    {
        $entity = new self();
        $entity->id = $id;
        $entity->email = new Email($email);
        $entity->roles = new Roles($roles);
        $entity->active = true;

        return $entity;
    }

    public static function createFromDTO(UserDTO $dto, \DateTimeImmutable $now): self
    {
        $entity = new self();
        $entity->forename = $dto->getForename();
        $entity->surname = $dto->getSurname();
        $entity->email = $dto->getEmail();
        $entity->plainPassword = $dto->getPassword();
        $entity->roles = $dto->getRoles();
        $entity->active = $dto->isActive();
        $entity->createdAt = $now;

        return $entity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getForename(): string
    {
        return $this->forename;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmailAddress(): string
    {
        return $this->email->getAddress();
    }

    public function getName(): string
    {
        return "{$this->forename} {$this->surname}";
    }

    public function getUsername(): string
    {
        return $this->email->getAddress();
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRoles(): array
    {
        return $this->roles->getRoles()->toArray();
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function isEqualTo(UserInterface $user): bool
    {
        return $this->getUsername() === $user->getUsername();
    }
}
