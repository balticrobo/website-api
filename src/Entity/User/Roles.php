<?php declare(strict_types=1);

namespace BalticRobo\Api\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Roles
{
    private const DEFAULT_ROLE = 'ROLE_USER';

    /**
     * @ORM\Column(type="json_collection")
     */
    private $roles;

    public function __construct(array $roles)
    {
        $this->roles = new ArrayCollection($roles);
    }

    public function getRoles(): Collection
    {
        if (!$this->roles->contains(self::DEFAULT_ROLE)) {
            $this->addRole(self::DEFAULT_ROLE);
        }

        return $this->roles;
    }

    public function addRole(string $role): void
    {
        $this->roles->add($role);
    }

    public function removeRole(string $role): void
    {
        if ($this->roles->removeElement($role)) {
            $this->roles = new ArrayCollection($this->roles->getValues());
        }
    }
}
