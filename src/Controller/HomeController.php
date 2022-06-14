<?php

namespace App\Controller;

use App\Form\SearchCakeFormType;
use App\Repository\CakeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, CakeRepository $cakeRepository): Response
    {
        // creating form
        $searchForm = $this->createForm(SearchCakeFormType::class);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $search = $searchForm->getData()['search'];

            return $this->redirectToRoute('app_cake_index', ['search' => $search]);
        }

        return $this->renderForm('home/index.html.twig', ['searchForm' => $searchForm]);
    }
}
