<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/espace-admin', name: 'app_admin_')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/gateaux', name: 'cakes')]
    public function cakesIndex(): Response
    {
        return $this->render('admin/cakeslist.html.twig');
    }

    #[Route('/commandes', name: 'orders')]
    public function ordersIndex(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();
        return $this->render('admin/orderslist.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/{id}', name: '_list')]
    public function detail(Order $order): Response
    {
        return $this->render('admin/ordersdetail.html.twig', [
            'order' => $order,
        ]);
    }
}
