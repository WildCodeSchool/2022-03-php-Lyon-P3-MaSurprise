<?php

namespace App\Controller;

use App\Entity\Baker;
use App\Entity\User;
use App\Form\BakerType;
use App\Repository\BakerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/patissier', name:'app_baker')]
class BakerController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(BakerRepository $bakerRepository): Response
    {
        $bakers = $bakerRepository->findAll();
        return $this->render('baker/index.html.twig', [
            'bakers' => $bakers,
        ]);
    }

    #[Route('/{id}', name: '_list')]
    public function detail(Baker $baker): Response
    {
        return $this->render('baker/show.html.twig', [
            'baker' => $baker,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/modifier', name: '_edit', methods: ['GET', 'POST'])]
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

    #[Route('/{id}', name: '_delete', methods: ['POST'])]
    public function delete(Request $request, Baker $baker, BakerRepository $bakerRepository): Response
    {
        if (is_string($request->request->get('_token')) || is_null($request->request->get('_token'))) {
            if ($this->isCsrfTokenValid('_delete' . $baker->getId(), $request->request->get('_token'))) {
                $bakerRepository->remove($baker, true);
            } else {
                throw new Exception(message : 'token should be string or null');
            }
        }

        return $this->redirectToRoute('app_baker_index', [], Response::HTTP_SEE_OTHER);
    }
}
