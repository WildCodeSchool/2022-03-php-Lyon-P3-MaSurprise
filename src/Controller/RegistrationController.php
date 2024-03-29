<?php

namespace App\Controller;

use App\Entity\Address;
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

#[Route('/creer-un-compte', name: 'app_register')]
class RegistrationController extends AbstractController
{
    #[Route('/', name: '_type')]
    public function bakerOrUser(): Response
    {
        //make sure a connected user cannot create a new account
        /** @var User $user */
        $user = $this->getUser();
        if ($user != null) {
            throw $this->createAccessDeniedException();
        }
        return $this->render('registration/type.html.twig');
    }

    #[Route('/patissier', name: '_baker')]
    public function newBaker(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        // need to set an empty address to see the address fields when a client want to create his account
        $billingAddress = new Address();
        $baker = new Baker();
        $user = new User();
        $baker->setUser($user);
        $user->addBillingAddress($billingAddress);
        $form = $this->createForm(BakerType::class, $baker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (is_string($form->get('user')->get('password')->getData())) {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('user')->get('password')->getData()
                    )
                );
                $user->setRoles(['ROLE_BAKER']);
                $entityManager->persist($baker);
                $entityManager->flush();
                return $this->redirectToRoute('app_home');
            }
        }

        return $this->renderForm('baker/new.html.twig', [
            'form' => $form, 'baker' => $baker,
        ]);
    }

    #[Route('/client', name: '_user')]
    public function newUser(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();
        // need to set an empty address to see the address fields when a client want to create his account
        $billingAddress = new Address();
        $user->addBillingAddress($billingAddress);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (is_string($form->get('password')->getData())) {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
                $user->setRoles(['ROLE_CUSTOMER']);
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('app_home');
            }
        }
        return $this->renderForm('user/new.html.twig', [
            'form' => $form, 'user' => $user,
        ]);
    }
}
