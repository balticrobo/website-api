<?php

namespace BalticRobo\Api\Controller\Cms;

use BalticRobo\Api\Entity\Competition\Competition;
use BalticRobo\Api\Model\Cms\AddCompetitionDTO;
use BalticRobo\Api\Service\Cms\CompetitionService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

final class CompetitionController extends Controller
{
    private $competitionService;

    public function __construct(CompetitionService $competitionService)
    {
        $this->competitionService = $competitionService;
    }

    /**
     * @Route("/cms/{year}/competition/list", name="cms_competition_list", requirements={"year" = "\d+"}, methods={"GET"})
     * *
     * @param int     $year
     */
    public function listAction(int $year): Response
    {
        $records = $this->competitionService->getListByYear($year);

        $records = $records->map(function(Competition $competition){
            return ['id' => $competition->getId(),
                    'name' => $competition->getName(),
                    'display_name' => $competition->getDisplayName(),
                    'registration_type' => $competition->getRegistrationType()];
        });

        return $this->json(['data' => ['competitions' => $records->toArray()], 'year' => $year, 'count' => $records->count()], Response::HTTP_OK);
    }

    /**
     * @Route("/cms/{year}/competition/add", name="cms_competition_add", requirements={"year" = "\d+"}, methods={"POST"})
     * *
     * @param int     $year
     */
    public function addAction(Request $request, int $year): Response
    {
        $this->competitionService->add(AddCompetitionDTO::createFromRequestAndYear($request, $year));

        return $this->json(['data' => ['success' => true]], Response::HTTP_OK);
    }
}
