<?php

namespace App\Controller;

use App\Repository\BakerRepository;
use App\Repository\CakeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/espace-patissier', name: 'app_baker_profile')]
class BakerProfileController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(CakeRepository $cakeRepository, BakerRepository $bakerRepository): Response
    {
        $cakes = $cakeRepository->findAll();
        $bakers = $bakerRepository->findAll();
        return $this->render('baker_profile/index.html.twig', [
            'cakes' => $cakes, 'baker' => $bakers
        ]);
    }
}
