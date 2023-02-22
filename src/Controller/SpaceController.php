<?php

namespace App\Controller;

use App\Entity\Space;
use App\Entity\Member;
use App\Form\SpaceType;
use App\Repository\SpaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/space')]
class SpaceController extends AbstractController
{
    #[Route('/', name: 'app_space_index', methods: ['GET'])]
    public function index(SpaceRepository $spaceRepository): Response
    {
        return $this->render('space/index.html.twig', [
            'spaces' => $spaceRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_space_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SpaceRepository $spaceRepository, Member $member): Response
    {
        $space = new Space();
        $space->setMember($member);
        $form = $this->createForm(SpaceType::class, $space);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $spaceRepository->save($space, true);

            return $this->redirectToRoute('app_space_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('space/new.html.twig', [
            'space' => $space,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_space_show', methods: ['GET'])]
    public function show(Space $space): Response
    {
        return $this->render('space/show.html.twig', [
            'space' => $space,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_space_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Space $space, SpaceRepository $spaceRepository): Response
    {
        $form = $this->createForm(SpaceType::class, $space);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $spaceRepository->save($space, true);

            return $this->redirectToRoute('app_space_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('space/edit.html.twig', [
            'space' => $space,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_space_delete', methods: ['POST'])]
    public function delete(Request $request, Space $space, SpaceRepository $spaceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$space->getId(), $request->request->get('_token'))) {
            $spaceRepository->remove($space, true);
        }

        return $this->redirectToRoute('app_space_index', [], Response::HTTP_SEE_OTHER);
    }
}
