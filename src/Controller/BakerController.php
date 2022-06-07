<?php

namespace App\Controller;

use App\Entity\Baker;
use App\Form\BakerType;
use App\Repository\BakerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/baker/new', name: 'baker_form')]
    public function newBaker(Request $request, BakerRepository $bakerRepository): Response
    {
        $baker = new Baker();
        $form = $this->createForm(BakerType::class, $baker);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $bakerRepository->add($baker, true);
            return $this->redirectToRoute('app_baker');
        }

        return $this->renderForm('baker/new.html.twig', [
            'form' => $form, 'baker' => $baker
        ]);
    }
}
