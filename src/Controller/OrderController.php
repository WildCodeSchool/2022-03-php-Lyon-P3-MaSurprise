<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AddressRepository;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

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
        $dateorder = $session->get('order');

        return $this->render('order/index.html.twig', [
            'address' => $address,
            'total' => $total,
            'datacart' => $datacart,
            'dateorder' => $dateorder,
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
        SessionInterface $session,
    ): Response {
        // fetching data from session
        $datacart = $session->get('datacart');
        $orderDate = $session->get('order');

        $orderDate = strval($orderDate);
        date_default_timezone_set('Europe/Paris');
        $orderDate = date_create($orderDate);
        $now = date_create("now");

        if($now < $orderDate && $orderDate !== false) {

            // getting user
            /** @var User $user */
            $user = $this->getUser();
            // calling service to add order
            $orderService->createOrder((array)$datacart, $user, $orderDate);
            // emptying cart
            $orderService->emptyCart();
            return $this->render('order/placed.html.twig');
        }

        $this->addFlash('warning', "Veuillez sélectionner une autre date.");
        return $this->redirectToRoute('app_order_index');
    }
}
