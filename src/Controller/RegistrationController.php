<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        if ($request->isMethod('POST')) {

            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $passwordConfirm = $request->request->get('password_confirm');

            if (strlen($password) < 8) {
                $this->addFlash('error', 'auth.error.password_length');
                return $this->redirectToRoute('app_register');
            }

            if ($password !== $passwordConfirm) {
                $this->addFlash('error', 'auth.error.password_mismatch');
                return $this->redirectToRoute('app_register');
            }

            $user = new User();
            $user->setEmail($email);

            $user->setPassword(
                $passwordHasher->hashPassword($user, $password)
            );

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/register.html.twig');
    }
}
