<?php

namespace App\Controller;

use App\Form\CakeType;
use App\Form\SearchCakeFormType;
use Exception;
use App\Entity\Cake;
use App\Repository\CakeRepository;
use App\Repository\DepartmentRepository;
use App\Service\CakeSearchService;
use App\Service\UploaderHelper as ServiceUploaderHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;

#[Route('/gateau', name: 'app_cake_')]
class CakeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        Request $request,
        CakeSearchService $cakeSearchService,
        DepartmentRepository $departmentRepository
    ): Response {
        // fetching all departments for the scrolling menu
        $departmentsDisplay = $departmentRepository->findAll();
        // creating form
        $searchForm = $this->createForm(SearchCakeFormType::class);
        $searchForm->handleRequest($request);
        // initializing search and department variables before the form is set
        $search = "";
        $department = "";

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $searchRequest = $request->get('search_cake_form');

            // some bricolage to please phpcs
            if (is_array($searchRequest)) {
                $search = $searchRequest['search'];
                $department = $searchRequest['department'];
            }
        }
        // calling the CakeSearchService

        $cakes = $cakeSearchService->cakeSearch($search, $department);

        return $this->renderForm('cake/index.html.twig', [
            'cakes' => $cakes,
            'searchForm' => $searchForm,
            'search' => $search,
            'departments' => $departmentsDisplay,
        ]);
    }

    // TODO: move this to security.yaml ?
    #[Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_BAKER')")]
    #[Route('/nouveau', name: 'new', methods: ['GET', 'POST'])]
    public function new(
        CakeRepository $cakeRepository,
        Request $request,
        RequestStack $requestStack
    ): Response {
        $cake = new Cake();
        $form = $this->createForm(CakeType::class, $cake);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cakeRepository->add($cake, true);
            // put the id in session is use to connect url pictures to the right cake
            $session = $requestStack->getSession();
            $session->set('cakeId', $cake->getId());
        }

        return $this->renderForm('cake/new.html.twig', [
            'cake' => $cake,
            'form' => $form,
        ]);
    }

    // This route is used while sending the cake form to rename uploaded files (cakes pictures)
    // and send them to the uploads folder
    #[Route('/uploadedfiles', name: 'uploadedfiles')]
    public function uploadCakesFiles(
        Request $request,
        RequestStack $requestStack,
        ServiceUploaderHelper $uploaderHelper,
        CakeRepository $cakeRepository
    ): Response {
        $session = $requestStack->getSession();
        $currentCakeId = $session->get('cakeId');

        $uploadedFiles = $request->files->get('files');
        if ($uploadedFiles) {
            if (is_iterable($uploadedFiles)) {
                $filesArray = [];
                foreach ($uploadedFiles as $uploadedFile) {
                    if ($uploadedFile instanceof UploadedFile) {
                        $newFilename = $uploaderHelper->uploadCakeFiles($uploadedFile);
                        $filesArray[] = $newFilename;
                    }
                }
                $files = implode(',', $filesArray);
                $cake = new Cake();
                $cake = $cakeRepository->find($currentCakeId);
                if ($cake != null) {
                    $cake->setPicture1($files);
                    $cakeRepository->add($cake, true);
                }
            }
        }
        return $this->redirectToRoute('app_cake_index');
    }

    #[Route('/{id}/modifier', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Cake $cake,
        Request $request,
        RequestStack $requestStack,
        CakeRepository $cakeRepository
    ): Response {
        $form = $this->createForm(CakeType::class, $cake);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cakeRepository->add($cake, true);
             // put the id in session is use to connect url pictures to the right cake
             $session = $requestStack->getSession();
             $session->set('updatedCakeId', $cake->getId());
        }

        return $this->renderForm('cake/edit.html.twig', [
            'cake' => $cake,
            'form' => $form,
        ]);
    }

    // this route is used to update files in edit cake form
    // and remove not longer needed pictures
    #[Route('/updated-files', name: 'updatedfiles')]
    public function updateCakesFiles(
        Request $request,
        ServiceUploaderHelper $uploaderHelper,
        RequestStack $requestStack,
        CakeRepository $cakeRepository
    ): Response {

        $session = $requestStack->getSession();
        $updatedCakeId = $session->get('updatedCakeId');

        $uploadedFiles = $request->files->get('files');
        if ($uploadedFiles) {
            if (is_iterable($uploadedFiles)) {
                $filesArray = [];
                foreach ($uploadedFiles as $uploadedFile) {
                    if ($uploadedFile instanceof UploadedFile) {
                        $newFilename = $uploaderHelper->uploadCakeFiles($uploadedFile);
                        $filesArray[] = $newFilename;
                    }
                }
                $files = implode(',', $filesArray);
                $cake = new Cake();
                $cake = $cakeRepository->find($updatedCakeId);
                if ($cake != null) {
                    $previousPictures = $cake->getPicture1();
                    $cake->setPicture1($previousPictures . ',' . $files);
                    $cakeRepository->add($cake, true);
                }
            }
        }
        return $this->redirectToRoute('app_cake_index');
    }

    #[Route('/{id}/', name: 'show')]
    public function show(Cake $cake): Response
    {
        return $this->render('cake/show.html.twig', [
            'cake' => $cake,
        ]);
    }

    // TODO: we need to block this route
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
