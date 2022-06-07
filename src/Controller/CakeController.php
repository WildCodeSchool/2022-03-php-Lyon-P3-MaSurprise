<?php

namespace App\Controller;

use App\Entity\Cake;
use App\Repository\CakeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CakeController extends AbstractController
{
    #[Route('/cake', name: 'app_cake')]
    public function index(CakeRepository $cakeRepository): Response
    {
        $cakes = $cakeRepository->findAll();
        return $this->render('cake/index.html.twig', [
            'cakes' => $cakes,
        ]);
    }

    #[Route('/cake/{id}/', name: 'app_cake_show')]
    public function show(Cake $cake): Response
    {

        return $this->render('cake/show.html.twig', [
            'cake' => $cake,
        ]);
    }
}
