<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/commande', name: 'app_order_')]
class OrderController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        AddressRepository $addressRepository,
        SessionInterface $session
    ): Response {
        /** @var User $user */
        $user = $this->getUser();
        $userId = $user->getId();
        $address = $addressRepository->findOneBy(['billingAddress' => $userId, 'status' => 1]);

        if (!$address) {
            $address = 'Aucune adresse renseignée.';
        }

        $total = $session->get('total', []);
        $cart = $session->get('cart', []);
        $datacart = $session->get('datacart');

        return $this->render('order/index.html.twig', [
            'address' => $address,
            'total' => $total,
            'cart' => $cart,
            'datacart' => $datacart,
        ]);
    }

    #[Route('/validation', name: 'processing')]
    public function orderProcess(): Response
    {
        return $this->render('order/processing.html.twig');
    }

    #[Route('/commande-validee', name: 'placed')]
    public function orderPlaced(): Response
    {
        return $this->render('order/placed.html.twig');
    }
}
