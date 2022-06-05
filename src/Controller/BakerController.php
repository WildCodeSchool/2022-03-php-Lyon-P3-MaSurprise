<?php

namespace App\Controller;

use App\Repository\BakerRepository;
use App\Entity\Baker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/baker', name: 'app_baker_')]
class BakerController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(BakerRepository $bakerRepository): Response
    {
        $bakers = $bakerRepository->findAll();
        return $this->render('baker/index.html.twig', [
            'bakers' => $bakers,
        ]);
    }

    #[Route('/{id}', name: 'list')]
    public function detail(Baker $baker): Response
    {
        return $this->render('baker/show.html.twig', [
            'baker' => $baker,
        ]);
    }
}
