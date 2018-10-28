<?php declare(strict_types=1);

namespace BalticRobo\Api\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SecurityController extends Controller
{
    /**
     * TODO: Prepare JSON Web Token
     *
     * @Route("/login", methods={"POST"})
     */
    public function loginAction(): Response
    {
        $user = $this->getUser();

        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
            'test' => true,
        ]);
    }
}
