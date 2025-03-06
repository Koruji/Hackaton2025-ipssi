<?php

namespace App\Controller;

use App\Entity\Chantier;
use App\Entity\Employes;
use App\Entity\Mission;
use App\Form\ChantierType;
use App\Repository\ChantierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/chantier')]
final class ChantierController extends AbstractController
{
    #[Route('/show/{id}', name: 'show_chantier')] //utilisé pour quand on clique sur un chantier dashboard
    public function show(EntityManagerInterface $em, $id): Response
    {
        $competences = $em->getRepository(Chantier::class)->findCompetencesByChantierId($id);
        $chantier = $em->getRepository(Chantier::class)->find($id);
        $missions = $em->getRepository(Mission::class)->findMissionsByChantierId($id);
        return $this->render('chantier/show.html.twig', [
            'chantier' => $chantier,
            'competences' => $competences,
            'missions' => $missions
        ]);
    }

    #[Route('/new', name: 'app_chantier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $chantier = new Chantier();
        $form = $this->createForm(ChantierType::class, $chantier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chantier);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_chantier', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chantier/new.html.twig', [
            'chantier' => $chantier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_chantier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chantier $chantier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChantierType::class, $chantier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_chantier', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chantier/edit.html.twig', [
            'chantier' => $chantier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chantier_delete', methods: ['POST'])]
    public function delete(Request $request, Chantier $chantier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chantier->getId(), $request->getPayload()->getString('_token'))) {
            $missions = $chantier->getMissions();
            foreach ($missions as $mission) {
                $entityManager->remove($mission);
            }
            $entityManager->remove($chantier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_chantier', [], Response::HTTP_SEE_OTHER);
    }
}
