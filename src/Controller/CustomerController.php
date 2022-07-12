<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Repository\AddressRepository;
use App\Repository\OrderRepository;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/espace-client', name: 'app_customer_')]
class CustomerController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('customer/index.html.twig');
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
            $address = "Aucune adresse renseignée.";
        }

        return $this->render('customer/show.html.twig', ['address' => $address]);
    }

    #[Route('/commandes', name: 'orders')]
    public function showOrders(
        OrderRepository $orderRepository,
    ): Response {
        /** @var User $user */
        $user = $this->getUser();
        $userId = $user->getId();
        $orders = $orderRepository->findBy(['buyer' => $userId], ['orderedAt' => 'DESC']);

        return $this->render('admin/orderslist.html.twig', ['orders' => $orders]);
    }

    #[Route('/modifier-mes-infos', name: 'edit')]
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        AddressRepository $addressRepository,
    ): Response {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        /** @var User $user */
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            // set last used address as inactive
            $lastAddressStatus = $addressRepository->findOneBy(['billingAddress' => $user, 'status' => true]);
            $lastAddressStatus?->setStatus(false);

            // add new address with user as foreign key
            $address->setBillingAddress($user);
            $addressRepository->add($address, true);

            $entityManager->persist($address);
            $entityManager->flush();

            return $this->redirectToRoute('app_customer_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm("customer/edit.html.twig", ['form' => $form]);
    }
}
