<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BakerController extends AbstractController
{
    #[Route('/baker', name: 'app_baker')]
    public function index(): Response
    {
        return $this->render('baker/index.html.twig', [
            'controller_name' => 'BakerController',
        ]);
    }
}
