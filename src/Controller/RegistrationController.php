<?php

namespace App\Controller;

use App\Entity\Baker;
use App\Entity\User;
use App\Form\BakerType;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/creer-un-compte', name: 'app_register')]
class RegistrationController extends AbstractController
{
    #[Route('/', name: '_type')]
    public function bakerOrUser(): Response
    {
        return $this->render('registration/type.html.twig');
    }

    #[Route('/patissier', name: '_baker')]
    public function newBaker(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $baker = new Baker();
        $user = new User();
        $baker->setUser($user);
        $form = $this->createForm(BakerType::class, $baker);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('user')->get('password')->getData()
                )
            );
                $entityManager->persist($baker);
                $entityManager->flush();
            return $this->redirectToRoute('app_baker_index');
        }
        return $this->renderForm('baker/new.html.twig', [
            'form' => $form, 'baker' => $baker
        ]);
    }

    #[Route('/client', name: '_user')]
    public function newUser(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
                $entityManager->persist($user);
                $entityManager->flush();
            return $this->redirectToRoute('/');
        }
        return $this->renderForm('user/new.html.twig', [
            'form' => $form, 'user' => $user
        ]);
    }
}
