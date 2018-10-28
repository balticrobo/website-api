<?php declare(strict_types=1);

namespace BalticRobo\Api\Entity\User;

use BalticRobo\Api\Exception\User\IncorrectEmailException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Email
{
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $address;

    public function __construct(string $address)
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new IncorrectEmailException($address);
        }
        $this->address = $address;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
}
