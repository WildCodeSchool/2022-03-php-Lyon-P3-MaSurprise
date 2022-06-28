<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\User;
use App\Repository\AddressRepository;
use App\Repository\BakerRepository;
use App\Repository\UserRepository;
use DateTimeInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commande', name: 'app_order_')]
class OrderController extends AbstractController
{
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
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
    public function orderProcess(
        EntityManagerInterface $entityManager,
        SessionInterface $session,
        AddressRepository $addressRepository,
        BakerRepository $bakerRepository,
        UserRepository $userRepository
    ): Response {
        $datacart = $session->get('datacart');

        /** @var User $user */
        $user = $this->getUser();
        $userId = $user->getId();
        $address = $addressRepository->findOneBy(['billingAddress' => $userId, 'status' => 1]);

        $order = new Order();

        foreach ($datacart as $data) {
            $cake = $data['cake'];
            $baker = $cake->getBaker();
            $bakerId = $baker->getId();

            $userBaker = $userRepository->findOneBy(['baker' => $bakerId]);

            $deliveryAddress = $addressRepository->findOneBy(['deliveryAddress' => $bakerId]);

            $order
                ->setOrderedAt(new DateTime())
                ->setBuyer($user)
                ->setSeller($userBaker)
                ->setCakeName($cake->getName())
                ->setCakePrice($cake->getPrice())
                ->setCakeSize($cake->getSize())
                ->setBillingAddress($address)
                ->setDeliveryAddress($deliveryAddress)
                ->setCollectDate(new DateTime());

            $entityManager->persist($order);
        }
        $entityManager->flush();

        return $this->render('order/processing.html.twig');
    }

    #[Route('/commande-validee', name: 'placed')]
    public function orderPlaced(): Response
    {
        return $this->render('order/placed.html.twig');
    }
}
