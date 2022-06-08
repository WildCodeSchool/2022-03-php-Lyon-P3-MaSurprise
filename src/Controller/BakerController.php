<?php

namespace App\Controller;

use App\Entity\Baker;
use App\Form\BakerType;
use App\Repository\BakerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/patissier', name:'app_baker_')]
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

    #[Route('/new', name: 'form')]
    public function newBaker(Request $request, BakerRepository $bakerRepository): Response
    {
        $baker = new Baker();
        $form = $this->createForm(BakerType::class, $baker);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $bakerRepository->add($baker, true);
            return $this->redirectToRoute('app_baker_index');
        }

        return $this->renderForm('baker/new.html.twig', [
            'form' => $form, 'baker' => $baker
        ]);
    }


    #[Route('/{id}', name: 'list')]
    public function detail(Baker $baker): Response
    {
        return $this->render('baker/show.html.twig', [
            'baker' => $baker,
        ]);
    }

    #[Route('/{id}/modifier', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Baker $baker, BakerRepository $bakerRepository): Response
    {
        $form = $this->createForm(BakerType::class, $baker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bakerRepository->add($baker, true);

            return $this->redirectToRoute('app_baker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('baker/edit.html.twig', [
            'baker' => $baker,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Baker $baker, BakerRepository $bakerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $baker->getId(), $request->request->get('_token'))) {
            $bakerRepository->remove($baker, true);
        }

        return $this->redirectToRoute('app_baker_index', [], Response::HTTP_SEE_OTHER);
    }
}
