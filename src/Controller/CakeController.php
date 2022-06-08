<?php

namespace App\Controller;

use App\Entity\Cake;
use App\Repository\CakeRepository;
use App\Form\CakeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cake')]
class CakeController extends AbstractController
{
    #[Route('/', name: 'app_cake_index')]
    public function index(CakeRepository $cakeRepository): Response
    {
        $cakes = $cakeRepository->findAll();
        return $this->render('cake/index.html.twig', [
            'cakes' => $cakes,
        ]);
    }

    #[Route('/{id}/', name: 'app_cake_show')]
    public function show(Cake $cake): Response
    {

        return $this->render('cake/show.html.twig', [
            'cake' => $cake,
        ]);
    }

    #[Route('/new', name: 'app_cake_new', methods: ['GET', 'POST'])]
    public function new(CakeRepository $cakeRepository, Request $request): Response
    {
        $cake = new Cake();
        $form = $this->createForm(CakeType::class, $cake);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cakeRepository->add($cake, true);

            return $this->redirectToRoute('app_cake_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cake/new.html.twig', [
            'cake' => $cake,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cake_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cake $cake, CakeRepository $cakeRepository): Response
    {
        $form = $this->createForm(CakeType::class, $cake);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cakeRepository->add($cake, true);

            return $this->redirectToRoute('app_cake_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cake/edit.html.twig', [
            'cake' => $cake,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cake_delete', methods: ['POST'])]
    public function delete(Request $request, Cake $cake, CakeRepository $cakeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $cake->getId(), $request->request->get('_token'))) {
            $cakeRepository->remove($cake, true);
        }

        return $this->redirectToRoute('app_cake_index', [], Response::HTTP_SEE_OTHER);
    }
}
