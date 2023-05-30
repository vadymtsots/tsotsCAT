<?php

namespace App\Controller\Auth;

use App\Entity\Users\User;
use App\Forms\Users\UserType;
use App\Services\Users\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/auth', name: 'auth_')]
class AuthController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(Request $request, UserService $userService): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $userService->createUser($form->getData());

            $this->addFlash(
                'success',
                'Your account has been created successfully'
            );

            return $this->redirectToRoute('auth_login');
        }

        return $this->render('auth/registration.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout()
    {
    }

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('auth/login.html.twig', [
            'error' => $error
        ]);
    }
}