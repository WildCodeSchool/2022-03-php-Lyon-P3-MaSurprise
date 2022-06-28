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

        // initializing total
        $total = 0;

        foreach ($datacart as $data) {
            // creating an order line per cake
            $orderLine = new OrderLine();
            // adding data to order line from session
            $orderLine
                ->setCakeName($data['cake']->getName())
                ->setCakePrice($data['cake']->getPrice())
                ->setCakeSize($data['cake']->getSize())
                ->setQuantity($data['quantity']);

            $this->entityManager->persist($orderLine);

            // calculating total
            $total += $data['cake']->getPrice() * $data['quantity'];

            /* TODO: useless, will have to work differently (must take seller and
            delivery address and put them in OrderLine even if it's really boring */
            $baker = $datacart[0]['cake']->getBaker();
            $bakerId = $baker->getId();
            $userBaker = $this->userRepository->findOneBy(['baker' => $bakerId]);
            $deliveryAddress = $this->addressRepository->findOneBy(['deliveryAddress' => $bakerId]);

            // prepping up datetime for date insertion
            // TODO: set it up for 24h display, currently 12h
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

        // TODO: there's a better way to do this probably
        unset($_SESSION['_sf2_attributes']['cart']);
        unset($_SESSION['_sf2_attributes']['datacart']);
        unset($_SESSION['_sf2_attributes']['total']);

        unset($_SESSION['Products']);
    }
}
