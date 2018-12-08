<?php
namespace BalticRobo\Api\Model\Cms;


use Symfony\Component\HttpFoundation\Request;

class AddCompetitionDTO
{
    private $display_name;
    private $name;
    private $year;
    private $registartionType;

    private function __construct()
    {
    }

    public static function createFromRequestAndYear(Request $request, int $year): self{
        $content = json_decode($request->getContent(), true);
        $dto = new self();

        $dto->setDisplayName($content['display_name']);
        $dto->setName($content['name']);
        $dto->setYear($year);
        $dto->setRegistrationType($content['registration_type']);

        return $dto;
    }

    public function getDisplayName(): ?string
    {
        return $this->display_name;
    }

    public function setDisplayName(string $display_name): void
    {
        $this->display_name = $display_name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    public function getRegistrationType(): ?int
    {
        return $this->registartionType;
    }

    public function setRegistrationType(int $registartionType): void
    {
        $this->registartionType = $registartionType;
    }
}