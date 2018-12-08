<?php


namespace BalticRobo\Api\Service\Cms;

use BalticRobo\Api\Entity\Competition\Competition;
use BalticRobo\Api\Model\Cms\AddCompetitionDTO;
use BalticRobo\Api\Repository\Competition\CompetitionRepository;
use Doctrine\Common\Collections\Collection;

class CompetitionService
{
    private $competitionRepository;

    public function __construct(CompetitionRepository $competitionRepository)
    {
        $this->competitionRepository = $competitionRepository;
    }

    public function getListByYear(int $year): Collection
    {
        return $this->competitionRepository->getRecordsByYear($year);
    }

    public function getTotal(): int
    {
        return $this->competitionRepository->getTotal();
    }

    public function add(AddCompetitionDTO $competitionDTO): void
    {
        $this->competitionRepository->save(Competition::createFromAddDTO($competitionDTO));
    }
}