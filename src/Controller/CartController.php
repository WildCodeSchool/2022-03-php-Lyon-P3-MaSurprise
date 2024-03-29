<?php

namespace App\Controller;

use App\Entity\Baker;
use App\Entity\Cake;
use App\Repository\CakeRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, CakeRepository $cakeRepository): Response
    {
        $cart = $session->get("cart", []);
        $dataCart = [];
        $total = 0;
        if (is_array($cart)) {
            foreach ($cart as $id => $quantity) {
                $cake = $cakeRepository->find($id);
                $dataCart[] = [
                    "cake" => $cake,
                    "quantity" => $quantity,
                ];
                if (!empty($cake)) {
                    $total += $cake->getPrice() * $quantity;
                }
            }
        }
        // transmitting info to order page
        $session->set("total", $total);
        $session->set('datacart', $dataCart);

        return $this->render('cart/index.html.twig', ["datacart" => $dataCart,
            "total" => $total,]);
    }

    #[Route('/ajouter/{id}', name: 'add')]
    public function add(
        CartService $cartService,
        Cake $cake,
        SessionInterface $session,
    ): Response {
        $datacart = $session->get("datacart");
        if (empty($datacart)) {
            $cartService->addCartService($cake->getId(), $session);
            return $this->redirectToRoute("cart_index");
        }

        if (!(is_array($datacart) && isset($datacart[0]))) {
            return $this->redirectToRoute('cart_index');
        }

        $data = $datacart[0];

        if (!$data['cake'] instanceof Cake) {
            return $this->redirectToRoute('cart_index');
        }

        $bakerData = $data['cake']->getBaker();

        if ($bakerData === null) {
            return $this->redirectToRoute('cart_index');
        }

        $bakerIn = $bakerData->getId();

        if ($bakerIn === null) {
            return $this->redirectToRoute('cart_index');
        }

        if ($cake->getBaker() instanceof Baker) {
            if ($bakerIn === $cake->getBaker()->getId()) {
                $cartService->addCartService($cake->getId(), $session);
                return $this->redirectToRoute("cart_index");
            }
        }

        $this->addFlash(
            'warning',
            "Vous ne pouvez pas commander chez deux pâtissiers en même temps,
             veuillez finaliser votre commande pour en passer une autre."
        );

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/enlever/{id}', name: 'remove')]
    public function remove(CartService $cartService, int $id, SessionInterface $session): Response
    {
        $cartService->removeCartService($id, $session);

        return $this->redirectToRoute("cart_index");
    }

    #[Route('/supprimer/{id}', name: 'delete')]
    public function delete(int $id, SessionInterface $session): Response
    {
        $cart = $session->get("cart", []);
        if (is_array($cart)) {
            if (!empty($cart[$id])) {
                unset($cart[$id]);
            }
        }
        $session->set("cart", $cart);

        return $this->redirectToRoute("cart_index");
    }
}
