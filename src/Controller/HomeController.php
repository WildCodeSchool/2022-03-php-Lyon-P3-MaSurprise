<?php

namespace App\Controller;

use App\Form\SearchCakeFormType;
use App\Repository\CakeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, CakeRepository $cakeRepository): Response
    {
        // creating form
        $searchForm = $this->createForm(SearchCakeFormType::class, [
            'action' => $this->generateUrl('app_cake_index'),
            'method' => 'POST',]);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            return $this->redirectToRoute('app_cake_index');
        }

        return $this->render('home/index.html.twig', ['searchForm' => $searchForm->createView()]);
    }
}
