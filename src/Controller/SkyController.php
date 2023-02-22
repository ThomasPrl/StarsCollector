<?php

namespace App\Controller;

use App\Entity\Sky;
use App\Entity\Star;
use App\Entity\Member;
use App\Form\Sky1Type;
use App\Repository\SkyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;


#[Route('/sky')]
class SkyController extends AbstractController
{
    #[Route('/', name: 'app_sky_index', methods: ['GET'])]
    public function index(SkyRepository $skyRepository): Response
    {
        return $this->render('sky/index.html.twig', [
            'skies' => $skyRepository->findBy(['publish' => true]),
        ]);
    }

    #[Route('/new/{id}', name: 'app_sky_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SkyRepository $skyRepository, Member $member): Response
    {
        $sky = new Sky();
        $sky->setCreateur($member);
        $form = $this->createForm(Sky1Type::class, $sky);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skyRepository->save($sky, true);

            return $this->redirectToRoute('app_sky_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sky/new.html.twig', [
            'sky' => $sky,
            'form' => $form,
        ]);
    }

    #[Route('/{sky_id}/star/{star_id}', name: 'app_sky_star_show', methods: ['GET'])]
    #[Entity('star', options: ['id' => 'star_id'])]
    #[Entity('sky', options: ['id' => 'sky_id'])]
    public function star_show(Star $star, Sky $sky): Response
    {
        return $this->render('sky/star_show.html.twig', [
            'star' => $star,
            'sky' => $sky,
        ]);
    }

    #[Route('/{id}', name: 'app_sky_show', methods: ['GET'])]
    public function show(Sky $sky): Response
    {
        return $this->render('sky/show.html.twig', [
            'sky' => $sky,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sky_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sky $sky, SkyRepository $skyRepository): Response
    {
        $form = $this->createForm(Sky1Type::class, $sky);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skyRepository->save($sky, true);

            return $this->redirectToRoute('app_sky_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sky/edit.html.twig', [
            'sky' => $sky,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sky_delete', methods: ['POST'])]
    public function delete(Request $request, Sky $sky, SkyRepository $skyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sky->getId(), $request->request->get('_token'))) {
            $skyRepository->remove($sky, true);
        }

        return $this->redirectToRoute('app_sky_index', [], Response::HTTP_SEE_OTHER);
    }

    
}
