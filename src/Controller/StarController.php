<?php

namespace App\Controller;

use App\Entity\Star;
use App\Form\StarType;
use App\Repository\StarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/star')]
class StarController extends AbstractController
{
    #[Route('/', name: 'app_star_index', methods: ['GET'])]
    public function index(StarRepository $starRepository): Response
    {
/*         if ($this->isGranted('ROLE_ADMIN')){
            $stars = $starRepository->findAll();
        }
        else {
            $member = $this->getUser()->getMember();
            $stars = $starRepository->findMemberStars($member);
        } */
        return $this->render('star/index.html.twig', [
            'stars' => $starRepository->findAll(),
        ]); 
    }

    #[Route('/new', name: 'app_star_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StarRepository $starRepository): Response
    {
        $star = new Star();
        $form = $this->createForm(StarType::class, $star);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $starRepository->save($star, true);

            return $this->redirectToRoute('app_star_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('star/new.html.twig', [
            'star' => $star,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_star_show', methods: ['GET'])]
    public function show(Star $star): Response
    {
        return $this->render('star/show.html.twig', [
            'star' => $star,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_star_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Star $star, StarRepository $starRepository): Response
    {
        $form = $this->createForm(StarType::class, $star);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $starRepository->save($star, true);

            return $this->redirectToRoute('app_star_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('star/edit.html.twig', [
            'star' => $star,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_star_delete', methods: ['POST'])]
    public function delete(Request $request, Star $star, StarRepository $starRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$star->getId(), $request->request->get('_token'))) {
            $starRepository->remove($star, true);
        }

        return $this->redirectToRoute('app_star_index', [], Response::HTTP_SEE_OTHER);
    }
}
