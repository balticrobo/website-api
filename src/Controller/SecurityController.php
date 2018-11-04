<?php declare(strict_types=1);

namespace BalticRobo\Api\Controller;

use BalticRobo\Api\Model\User\TokenDataDTO;
use BalticRobo\Api\Service\User\AuthenticationService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SecurityController extends Controller
{
    private $authentication;

    public function __construct(AuthenticationService $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * @Route("/login", methods={"POST"})
     */
    public function loginAction(Request $request): Response
    {
        $tokenData = TokenDataDTO::createFromRequestUserAndTime($request, $this->getUser(), new \DateTimeImmutable());
        $token = $this->authentication->createToken($tokenData)->getToken();

        return $this->json(['data' => ['token' => $token]], Response::HTTP_OK);
    }
}
