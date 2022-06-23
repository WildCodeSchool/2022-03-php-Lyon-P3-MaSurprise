<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/espace-client', name: 'app_customer_')]
class CustomerController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('customer/index.html.twig');
    }

    #[Route('/profil', name: 'show')]
    public function show(): Response
    {
        return $this->render('customer/show.html.twig');
    }

    #[Route('/commandes', name: 'orders')]
    public function showOrders(OrderRepository $orderRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $orders = [];

        /** @var User $user */
        $user = $this->getUser();
        dump($this->getUser());

        $userId = $user->getId();
        $orders = $orderRepository->findBy(['buyer' => $userId]);


        return $this->render('customer/orders.html.twig', ['orders' => $orders]);
    }
}
