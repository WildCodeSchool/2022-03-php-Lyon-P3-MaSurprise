<?php

namespace App\Controller;

use App\Repository\CakeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, CakeRepository $cakeRepository): Response
    {
        //on recup le panier
        $cart = $session->get("cart", []);
        // on fabrique les données
        $dataCart = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $cake = $cakeRepository->find($id);
            $dataCart[] = [
                "cake" => $cake,
                "quantity" => $quantity,
            ];

            $total += $cake->getPrice() * $quantity;
        }

        return $this->render('cart/index.html.twig', [
            "datacart" => $dataCart,
            "total" => $total,
        ]);
    }

    #[Route('/add/{id}', name: 'add')]
    public function add(int $id, SessionInterface $session): Response
    {

        //on recupere le panier actuel, si il n'existe pas je crée un tableau vide il vaut soit cart soit tableau vide
        $cart = $session->get("cart", []);
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        // on safe dans la session

        $session->set("cart", $cart);

        return $this->redirectToRoute("cart_index");
    }

    #[Route('/remove/{id}', name: 'remove')]
    public function remove(int $id, SessionInterface $session): Response
    {

        //on recupere le panier actuel, si il n'existe pas je crée un tableau vide il vaut soit cart soit tableau vide
        $cart = $session->get("cart", []);
        if (!empty($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            }
        } else {
            //on suprime la ligne si elle tombe a 0
            unset($cart[$id]);
        }


        // on safe dans la session

        $session->set("cart", $cart);

        return $this->redirectToRoute("cart_index");
    }

    #[
        Route('/delete/{id}', name: 'delete')]
    public function delete(int $id, SessionInterface $session): Response
    {

        //on recupere le panier actuel, si il n'existe pas je crée un tableau vide il vaut soit cart soit tableau vide
        $cart = $session->get("cart", []);

        //on suprime la ligne
        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }


        // on safe dans la session

        $session->set("cart", $cart);

        return $this->redirectToRoute("cart_index");
    }
}
