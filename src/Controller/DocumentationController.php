<?php declare(strict_types=1);

namespace BalticRobo\Api\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;

final class DocumentationController extends Controller
{
    /**
     * @Route("/doc", methods={"GET"})
     */
    public function openApiAction(): Response
    {
        $rootDir = $this->getParameter('kernel.project_dir');
        $json = Yaml::parseFile("${rootDir}/config/openapi.yaml");

        return $this->json($json, Response::HTTP_OK);
    }
}
