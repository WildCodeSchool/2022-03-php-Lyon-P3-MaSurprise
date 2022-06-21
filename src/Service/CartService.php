<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{

    function addCartService(int $id, SessionInterface $session): mixed
    {
//on recupere le panier actuel, si il n'existe pas je crée un tableau vide il vaut soit cart soit tableau vide
        $cart = $session->get("cart", []);
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        // on safe dans la session
        return $session->set("cart", $cart);
    }

    public function removeCartService(int $id, SessionInterface $session): mixed
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

        return $session->set("cart", $cart);
    }
}

