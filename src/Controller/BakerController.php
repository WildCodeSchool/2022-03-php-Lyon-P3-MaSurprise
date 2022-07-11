<?php

namespace App\Controller;

use App\Entity\Baker;
use App\Form\BakerType;
use App\Form\BakerModifyType;
use App\Repository\BakerRepository;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/patissier', name: 'app_baker')]
class BakerController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/', name: '_index')]
    public function index(BakerRepository $bakerRepository): Response
    {
        $bakers = $bakerRepository->findAll();
        return $this->render('baker/index.html.twig', [
            'bakers' => $bakers,
        ]);
    }

    #[Route('/nouveau', name: '_form')]
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

    #[Route('/{id}', name: '_list')]
    public function detail(Baker $baker): Response
    {
        return $this->render('baker/show.html.twig', [
            'baker' => $baker,
        ]);
    }

    #[Route('/{id}/modifier', name: '_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Baker $baker, BakerRepository $bakerRepository): Response
    {
        $modifyForm = $this->createForm(BakerModifyType::class, $baker);
        $modifyForm->handleRequest($request);

        if ($modifyForm->isSubmitted() && $modifyForm->isValid()) {
            $bakerRepository->add($baker, true);

            return $this->redirectToRoute('app_baker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('baker/edit.html.twig', [
            'baker' => $baker,
            'modifyForm' => $modifyForm,
        ]);
    }

    // TODO: do we keep this here or do we move it in secutiry.yaml?
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: '_delete', methods: ['POST'])]
    public function delete(Request $request, Baker $baker, BakerRepository $bakerRepository): Response
    {
        if (is_string($request->request->get('_token')) || is_null($request->request->get('_token'))) {
            if ($this->isCsrfTokenValid('_delete' . $baker->getId(), $request->request->get('_token'))) {
                $bakerRepository->remove($baker, true);
            } else {
                throw new Exception(message: 'token should be string or null');
            }
        }

        return $this->redirectToRoute('app_baker_index', [], Response::HTTP_SEE_OTHER);
    }
}
