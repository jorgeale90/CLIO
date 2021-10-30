<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\EspecialistaRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/perfil", name="user_perfil")
     */
    public function index(EspecialistaRepository $especialistaRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'perfilusers' => $especialistaRepository->findAll(),
        ]);
    }
}