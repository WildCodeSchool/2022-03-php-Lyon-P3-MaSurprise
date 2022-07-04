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
        // creating an order
        $order = new Order();
        $total = 0;

        foreach ($datacart as $data) {
            // fetching baker and their address
            $baker = $data['cake']->getBaker();
            $bakerId = $baker->getId();
            $userBaker = $this->userRepository->findOneBy(['baker' => $bakerId]);
            $deliveryAddress = $this->addressRepository->findOneBy(['deliveryAddress' => $bakerId]);

            // calculating total
            $total += $data['cake']->getPrice() * $data['quantity'];

            // creating an order line per cake
            $orderLine = new OrderLine();
            // adding data to order line from session
            $orderLine
                ->setOrderReference($order)
                ->setCakeName($data['cake']->getName())
                ->setCakePrice($data['cake']->getPrice())
                ->setCakeSize($data['cake']->getSize())
                ->setQuantity($data['quantity'])
                ->setSeller($userBaker)
                ->setDeliveryAddress($deliveryAddress);

            $this->entityManager->persist($orderLine);
        }

        // prepping up datetime for date insertion
        $datetime = new DateTime();
        $timezone = new DateTimeZone('Europe/Paris');
        $datetime->setTimezone($timezone);

        // fetching user and getting their id
        $userId = $user->getId();
        $address = $this->addressRepository->findOneBy(['billingAddress' => $userId, 'status' => 1]);

        // creating order number
        $number =
            rand(1, 9) .
            strtoupper(substr($user->getLastname(), 0, 2)) .
            rand(1000, 9999) .
            substr(strval(floor(microtime(true) * 1000)), -6);

        // adding data to order
        $order
            ->setOrderedAt($datetime)
            ->setNumber($number)
            ->setBuyer($user)
            ->setTotal($total)
            ->setBillingAddress($address)
            ->setCollectDate($datetime);

        $this->entityManager->persist($order);

        // saving order
        $this->entityManager->flush();
    }

    public function emptyCart(): void
    {
        // TODO: there's a better way to do this probably
        // emptying cart when order is complete
        unset($_SESSION['_sf2_attributes']['cart']);
        unset($_SESSION['_sf2_attributes']['datacart']);
        unset($_SESSION['_sf2_attributes']['total']);

        unset($_SESSION['Products']);
    }
}
