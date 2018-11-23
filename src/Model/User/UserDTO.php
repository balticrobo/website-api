<?php declare(strict_types=1);

namespace BalticRobo\Api\Model\User;

use BalticRobo\Api\Entity\User\Email;
use BalticRobo\Api\Entity\User\Roles;

final class UserDTO
{
    private $forename;
    private $surname;
    private $email;
    private $roles;
    private $password;
    private $active = false;

    public function __construct(string $forename, string $surname, Email $email, Roles $roles)
    {
        $this->forename = $forename;
        $this->surname = $surname;
        $this->email = $email;
        $this->roles = $roles;
    }

    public function setPlainPassword(string $plainPassword): void
    {
        $this->password = $plainPassword;
    }

    public function setActive(bool $active = true)
    {
        $this->active = $active;
    }

    public function getForename(): string
    {
        return $this->forename;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getRoles(): Roles
    {
        return $this->roles;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
