<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    public function addCartService(int $id, SessionInterface $session): int
    {
        $cart = $session->get("cart", []);
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        return $session->set("cart", $cart);
    }

    public function removeCartService(int $id, SessionInterface $session): int
    {
        $cart = $session->get("cart", []);
        if (!empty($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }

        return $session->set("cart", $cart);
    }
}
