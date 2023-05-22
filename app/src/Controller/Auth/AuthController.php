<?php

namespace App\Controller\Auth;

use App\Entity\Users\User;
use App\Forms\Users\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/auth', name: 'auth_')]
class AuthController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        return $this->render('auth/registration.html.twig', [
            'form' => $form,
        ]);
    }

    public function logout()
    {
    }

    public function login()
    {
        return $this->render('auth/login.html.twig');
    }
}