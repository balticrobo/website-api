<?php declare(strict_types=1);

namespace BalticRobo\Api\Controller;

use BalticRobo\Api\Model\User\TokenDataDTO;
use BalticRobo\Api\Model\User\TokenDTO;
use BalticRobo\Api\ResponseModel\User\TokenResponse;
use BalticRobo\Api\Service\User\AuthenticationService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/security/token")
 */
final class SecurityController extends Controller
{
    private $authentication;

    public function __construct(AuthenticationService $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * @Route("/create", methods={"POST"})
     */
    public function createTokenAction(Request $request): Response
    {
        $tokenData = TokenDataDTO::createFromRequestUserAndTime($request, $this->getUser(), new \DateTimeImmutable());
        $token = $this->authentication->createToken($tokenData);

        return $this->json((new TokenResponse($token))->respond(), Response::HTTP_OK);
    }

    /**
     * @Route("/refresh", methods={"POST"})
     */
    public function refreshTokenAction(Request $request): Response
    {
        dd($this->getUser());
    }
}
