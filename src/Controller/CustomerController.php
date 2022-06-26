<?php

namespace App\Controller;

use App\Form\AddressType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/espace-client', name: 'app_customer_')]
class CustomerController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('customer/index.html.twig');
    }

    #[Route('/show', name: 'show')]
    public function show(): Response
    {
        return $this->render('customer/show.html.twig');
    }

    #[Route('/modifier-mes-infos', name: 'edit')]
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ): Response {
        $form = $this->createForm(AddressType::class);
        $form->handleRequest($request);

//        $user = $this->getUser();
//        $userId = $user->getId();

//        $userToModify = $userRepository->find($userId);

//        if ($form->isSubmitted() && $form->isValid()) {
//            $userToModify->setBillingAddress();
//
//            $entityManager->persist($user);
//            $entityManager->flush();
//        }

        return $this->renderForm("customer/edit.html.twig", ['form' => $form]);
    }
}
