<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderLine;
use App\Entity\User;
use App\Repository\AddressRepository;
use App\Repository\UserRepository;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrderService
{
    private UserRepository $userRepository;
    private AddressRepository $addressRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UserRepository $userRepository,
        AddressRepository $addressRepository,
        EntityManagerInterface $entityManager,
    ) {
        $this->userRepository = $userRepository;
        $this->addressRepository = $addressRepository;
        $this->entityManager = $entityManager;
    }

    public function createOrder(
        array $datacart,
        SessionInterface $session,
        User $user
    ): void {
        // fetching user and getting its id
        $userId = $user->getId();
        $address = $this->addressRepository->findOneBy(['billingAddress' => $userId, 'status' => 1]);

        // creating an order
        $order = new Order();

        $total = 0;

        foreach ($datacart as $data) {
            $orderLine = new OrderLine();
            // adding data to order line
            $orderLine
                ->setCakeName($data['cake']->getName())
                ->setCakePrice($data['cake']->getPrice())
                ->setCakeSize($data['cake']->getSize())
                ->setQuantity($data['quantity']);

            $this->entityManager->persist($orderLine);

            $total += $data['cake']->getPrice() * $data['quantity'];

            // useless, will have to work differently
            $baker = $datacart[0]['cake']->getBaker();
            $bakerId = $baker->getId();
            $userBaker = $this->userRepository->findOneBy(['baker' => $bakerId]);
            $deliveryAddress = $this->addressRepository->findOneBy(['deliveryAddress' => $bakerId]);

            // prepping up datetime for date insertion
            $datetime = new DateTime();
            $timezone = new DateTimeZone('Europe/Paris');
            $datetime->setTimezone($timezone);

            // adding data to order
            $order
                ->setOrderedAt($datetime)
                ->setBuyer($user)
                ->setSeller($userBaker)
                ->setTotal($total)
                ->setBillingAddress($address)
                ->setDeliveryAddress($deliveryAddress)
                ->setCollectDate($datetime)
                ->addOrderLine($orderLine);

            $this->entityManager->persist($order);
        }
        // saving order
        $this->entityManager->flush();
    }
}
