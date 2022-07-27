<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AddressRepository;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

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
        $meetingTime = $session->get('order');
        $address = $addressRepository->findOneBy(['billingAddress' => $userId, 'status' => 1]);

        if (!$address) {
            $address = 'Aucune adresse renseignée.';
        }


        $total = $session->get('total', []);
        $datacart = $session->get('datacart');

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['meetingTime'])) {
            $order = $_POST['meetingTime'];
            date_default_timezone_set('Europe/Paris');
            $orderDate = date_create($order);
            $now = date_create("now");

            $diff = $orderDate->diff($now);

            if ($diff->invert == 0) {
                $this->addFlash(
                    'warning',
                    "Merci de selectionner une autre date."
                );
                return $this->redirectToRoute('app_order_index');
            }

            $session->set('orderDate', $orderDate);
            return $this->redirectToRoute('app_order_processing');
        }

        return $this->render('order/index.html.twig', [
            'address' => $address,
            'total' => $total,
            'datacart' => $datacart,
            'meetingTime' => $meetingTime,
        ]);
    }

    #[
        Route('/validation', name: 'processing')]
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
        $orderDate = $session->get('orderDate');

        // TODO: could we maybe move this to index?
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
