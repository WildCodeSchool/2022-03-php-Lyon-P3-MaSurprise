<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\CakeRepository;
use App\Repository\OrderRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/espace-admin', name: 'app_admin_')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/gateaux', name: 'cakes')]
    public function cakesIndex(CakeRepository $cakeRepository): Response
    {
        $cakes = $cakeRepository->findAll();
        return $this->render('admin/cakeslist.html.twig', [
            'cakes' => $cakes,
        ]);
    }

    #[Route('/commandes', name: 'orders')]
    public function ordersIndex(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();
        return $this->render('admin/orderslist.html.twig', [
            'orders' => $orders,
        ]);
    }
}
