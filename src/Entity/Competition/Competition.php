<?php

namespace BalticRobo\Api\Entity\Competition;

use BalticRobo\Api\Model\Cms\AddCompetitionDTO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="BalticRobo\Api\Repository\Competition\CompetitionRepository")
 */
class Competition
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $display_name;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\Column(type="smallint")
     */
    private $year;

    /**
     * @ORM\Column(type="smallint")
     */
    private $registrationType;

    public static function createFromAddDTO(AddCompetitionDTO $dto): self
    {
        $entity = new self();
        $entity->display_name = $dto->getDisplayName();
        $entity->name = $dto->getName();
        $entity->year = $dto->getYear();
        $entity->registrationType = $dto->getRegistrationType();

        return $entity;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDisplayName(): ?string
    {
        return $this->display_name;
    }

    public function setDisplayName(string $display_name): self
    {
        $this->display_name = $display_name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getRegistrationType(): ?int
    {
        return $this->registrationType;
    }

    public function setRegistrationType(int $registrationType): self
    {
        $this->registrationType = $registrationType;

        return $this;
    }
}
