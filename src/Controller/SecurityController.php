<?php declare(strict_types=1);

namespace BalticRobo\Api\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SecurityController extends AbstractController
{
    /**
     * @Route("/login", methods={"POST"})
     */
    public function login(Request $request): Response
    {
        $user = $this->getUser();

        return $this->json(array(
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
        ));
    }
}
