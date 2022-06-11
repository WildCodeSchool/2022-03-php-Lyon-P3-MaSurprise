<?php

namespace App\Controller;

use App\Form\SearchCakeFormType;
use Exception;
use App\Entity\Cake;
use App\Form\CakeType;
use App\Repository\CakeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/cake', name: 'app_cake_')]
class CakeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, CakeRepository $cakeRepository): Response
    {
        // creating form
        $searchForm = $this->createForm(SearchCakeFormType::class);
        $searchForm->handleRequest($request);
        $errors = "";

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            //fetching data from form
            $search = $searchForm->getData()['search'];

            if (!$search) {
                // if the form is submitted empty, display everything
                $cakes = $cakeRepository->findAll();
            } else {
                // else, display name-matched AND description-matched results
                $cakes = $cakeRepository->findLikeName($search);
                $cakes += $cakeRepository->findLikeDescription($search);

                // display a message if none found
                if (
                    $cakeRepository->findLikeName($search) == null &&
                    $cakeRepository->findLikeDescription($search) == null
                ) {
                    $errors = "Oh non, aucun gâteau ne correspond à vos critères de recherche...
                Laissez-vous tenter par d'autres choix ci-dessous !";
                    $cakes = $cakeRepository->findAll();
                }
            }
        } else {
            // default: displaying all cakes
            $cakes = $cakeRepository->findAll();
        }

        return $this->render('cake/index.html.twig', [
            'cakes' => $cakes,
            'searchForm' => $searchForm->createView(),
            'errors' => $errors,
        ]);
    }

    #[Route('/{id}/', name: 'show')]
    public function show(Cake $cake): Response
    {
        return $this->render('cake/show.html.twig', [
            'cake' => $cake,
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
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

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
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

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Cake $cake, CakeRepository $cakeRepository): Response
    {
        if (is_string($request->request->get('_token')) || is_null($request->request->get('_token'))) {
            if ($this->isCsrfTokenValid('delete' . $cake->getId(), $request->request->get('_token'))) {
                $cakeRepository->remove($cake, true);
            } else {
                throw new Exception('Impossible de supprimer le gateau');
            }
        }
        return $this->redirectToRoute('app_cake_index', [], Response::HTTP_SEE_OTHER);
    }
}
