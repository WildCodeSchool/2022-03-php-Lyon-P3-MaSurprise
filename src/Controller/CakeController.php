<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CakeController extends AbstractController
{
    #[Route('/cake', name: 'app_cake')]
    public function index(): Response
    {
        return $this->render('cake/index.html.twig', [
            'controller_name' => 'CakeController',
        ]);
    }
}
