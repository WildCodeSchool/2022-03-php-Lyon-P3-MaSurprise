<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\User;
use App\Repository\AddressRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
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

        $total = $session->get('total', []);
        $datacart = $session->get('datacart');

        return $this->render('order/index.html.twig', [
            'address' => $address,
            'total' => $total,
            'datacart' => $datacart,
        ]);
    }

    #[Route('/validation', name: 'processing')]
    public function orderProcess(): Response
    {
        return $this->render('order/processing.html.twig');
    }

    #[Route('/commande-validee', name: 'placed')]
    public function orderPlaced(
        EntityManagerInterface $entityManager,
        SessionInterface $session,
        AddressRepository $addressRepository,
        UserRepository $userRepository
    ): Response {
        // fetching data from session
        $datacart = $session->get('datacart');

        // fetching user and getting its id
        /** @var User $user */
        $user = $this->getUser();
        $userId = $user->getId();
        $address = $addressRepository->findOneBy(['billingAddress' => $userId, 'status' => 1]);

        // creating an order
        $order = new Order();

        foreach ($datacart as $data) {
            // getting initial data
            $cake = $data['cake'];
            $baker = $cake->getBaker();
            $bakerId = $baker->getId();
            $userBaker = $userRepository->findOneBy(['baker' => $bakerId]);
            $deliveryAddress = $addressRepository->findOneBy(['deliveryAddress' => $bakerId]);

            // adding data to order
            $order
                ->setOrderedAt(new DateTime())
                ->setBuyer($user)
                ->setSeller($userBaker)
                ->setCakeName($cake->getName())
                ->setCakePrice($cake->getPrice())
                ->setTotal($cake->getPrice())
                ->setCakeSize($cake->getSize())
                ->setBillingAddress($address)
                ->setDeliveryAddress($deliveryAddress)
                ->setCollectDate(new DateTime());

            $entityManager->persist($order);
        }
        // saving order
        $entityManager->flush();

        return $this->render('order/placed.html.twig');
    }
}
