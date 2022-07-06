<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AddressRepository;
use App\Service\OrderService;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use DateTime;

#[Route('/commande', name: 'app_order_')]
class OrderController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        AddressRepository $addressRepository,
        SessionInterface $session,
    ): Response {
        /** @var User $user */
        $user = $this->getUser();
        $userId = $user->getId();
        $address = $addressRepository->findOneBy(['billingAddress' => $userId, 'status' => 1]);

        if (!$address) {
            $address = 'Aucune adresse renseignée.';
        }

        if (isset($_POST['meeting-time'])) {
            $session->set('order', $_POST['meeting-time']);
        }

        $total = $session->get('total', []);
        $datacart = $session->get('datacart');


        return $this->render('order/index.html.twig', [
            'address' => $address,
            'total' => $total,
            'datacart' => $datacart,
        ]);
    }

    #[Route('/validation', name: 'processing')]
    public function orderProcess(SessionInterface $session): Response
    {

        return $this->render('order/processing.html.twig');
    }

    #[Route('/commande-validee', name: 'placed')]
    public function orderPlaced(
        OrderService $orderService,
        SessionInterface $session
    ): Response {
        // fetching data from session
        $datacart = $session->get('datacart');
        $orderDate = $session->get('order');

        // getting user
        /** @var User $user */
        $user = $this->getUser();

        // calling service to add order
        $orderService->createOrder((array)$datacart, $user, $orderDate);

        // emptying cart
        $orderService->emptyCart();

        return $this->render('order/placed.html.twig');
    }
}
