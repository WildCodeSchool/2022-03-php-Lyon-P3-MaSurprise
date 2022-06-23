<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/espace-client', name: 'app_customer_')]
class CustomerController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('customer/index.html.twig');
    }

    #[Route('/show', name: 'show')]
    public function show(): Response
    {
        return $this->render('customer/show.html.twig');
    }
}
