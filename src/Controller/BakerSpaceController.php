<?php

namespace App\Controller;

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

        return $this->render('baker_space/show.html.twig', ['address' => $address]);
    }

    #[Route('/gateaux', name: 'cakes')]
    public function cakesIndex(
        CakeRepository $cakeRepository,
        UserRepository $userRepository
    ): Response {
        /** @var User $user */
        $user = $this->getUser();
        $userId = $user->getId();

        $user = $userRepository->findOneBy(['id' => $userId]);
        $baker = $user->getBaker();

        $cakes = $cakeRepository->findBy(['baker' => $baker->getId()]);
        return $this->render('admin/cakeslist.html.twig', [
            'cakes' => $cakes,
        ]);
    }

//    #[Route('/commandes', name: 'orders')]
//    public function ordersIndex(
//        OrderRepository     $orderRepository,
//        UserRepository      $userRepository,
//        OrderLineRepository $orderLineRepository
//    ): Response
//    {
//        /** @var User $user */
//        $user = $this->getUser();
//        $userId = $user->getId();
//
//        $user = $userRepository->findOneBy(['id' => $userId]);
//
//        $orderLines = $orderLineRepository->findBy(['seller' => $user->getId()]);
//
//        return $this->render('admin/orderslist.html.twig', [
//            'orders' => $orders,
//        ]);
//    }
}
