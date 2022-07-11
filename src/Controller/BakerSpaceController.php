<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\User;
use App\Repository\AddressRepository;
use App\Repository\CakeRepository;
use App\Repository\OrderLineRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/espace-patissier', name: 'app_bakerspace_')]
class BakerSpaceController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('baker_space/index.html.twig');
    }

    #[Route('/profil', name: 'show')]
    public function show(
        AddressRepository $addressRepository,
    ): Response {
        /** @var User $user */
        $user = $this->getUser();
        $userId = $user->getId();

        $address = $addressRepository->findOneBy(['billingAddress' => $userId, 'status' => 1]);

        if (!$address) {
            $address = 'Aucune adresse renseignée.';
        }

        return $this->render('customer/show.html.twig', ['address' => $address]);
    }

    #[Route('/gateaux', name: 'cakes')]
    public function cakesIndex(
        CakeRepository $cakeRepository,
        UserRepository $userRepository
    ): Response {
        // I hate to do this
        // initializing baker only to pass validation scripts
        $baker = "";
        $cakes = [];

        /** @var User $user */
        $user = $this->getUser();
        $userId = $user->getId();

        $user = $userRepository->findOneBy(['id' => $userId]);
        if ($user) {
            $baker = $user->getBaker();
        }

        if ($baker) {
            $cakes = $cakeRepository->findBy(['baker' => $baker->getId()]);
        }

        return $this->render('admin/cakeslist.html.twig', [
            'cakes' => $cakes,
        ]);
    }

    #[Route('/commandes', name: 'orders')]
    public function ordersIndex(OrderLineRepository $orderLineRepository,): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $userId = $user->getId();

        // TODO: check if this work when we have coherent, realistic data
        $orderLines = $orderLineRepository->findBy(['seller' => $userId], ['orderReference' => "ASC"]);

        $orders = [];

        if ($orderLines) {
            // getting orders from orderLines references
            foreach ($orderLines as $orderLine) {
                $key = $orderLine->getOrderReference()->getId();

                if (!array_key_exists($key, $orders)) {
                    $orders[$key] = $orderLine->getOrderReference();
                }
            }
        }

        return $this->render('admin/orderslist.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/{id}/validation-patissier', name: 'order_validation')]
    public function bakerOrderValidation(Order $order, OrderRepository $orderRepository): Response
    {
        switch ($_POST['status']) {
            case 1:
                $order->setOrderStatus('Commande créée');
                break;
            case 2:
                $order->setOrderStatus('Commande validée');
                break;
            case 3:
                $order->setOrderStatus('Commande en préparation');
                break;
            case 4:
                $order->setOrderStatus('Commande disponible en retrait');
                break;
            case 5:
                $order->setOrderStatus('Commande retirée');
                break;
            case 6:
                $order->setOrderStatus('Commande terminée');
                break;
            case 7:
                $order->setOrderStatus('Commande annulée');
                break;
        }
        $orderRepository->add($order, true);
        $this->addFlash('success', 'Le changement de statut a bien été pris en compte.');

        return $this->redirectToRoute('app_bakerspace_orders');
    }
}
