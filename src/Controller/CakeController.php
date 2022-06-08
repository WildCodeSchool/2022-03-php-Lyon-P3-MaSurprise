<?php

namespace App\Controller;

use _PHPStan_0a43b4828\Nette\Neon\Exception;
use App\Entity\Cake;
use App\Repository\CakeRepository;
use App\Form\CakeType;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;
use phpDocumentor\Reflection\Types\Void_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function _PHPStan_0a43b4828\RingCentral\Psr7\str;
use function PHPUnit\Framework\throwException;

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
