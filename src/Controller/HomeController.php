<?php

namespace App\Controller;

use App\Repository\DepartmentRepository;
use App\Form\SearchCakeFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(DepartmentRepository $departmentRepository): Response
    {
        // creating form which will redirect to cakes page when submitted
        $searchForm = $this->createForm(SearchCakeFormType::class);
        $departments = $departmentRepository->findAll();

        return $this->renderForm('home/index.html.twig', [
            'searchForm' => $searchForm,
            'departments' => $departments,
        ]);
    }

    #[Route('/nos-services', name: 'services')]
    public function showServices(): Response
    {
        return $this->render('services/index.html.twig');
    }
}
