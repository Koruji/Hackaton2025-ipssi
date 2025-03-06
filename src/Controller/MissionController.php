<?php

namespace App\Controller;

use App\Entity\Chantier;
use App\Entity\Mission;
use App\Form\MissionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mission')]
final class MissionController extends AbstractController
{
    #[Route('/new/{id}', name: 'app_mission_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $mission = new Mission();
        $chantier = $entityManager->getRepository(Chantier::class)->find($id);
        $competencesChantier = [];
        foreach ($chantier->getCompetences() as $competence) {
            array_push($competencesChantier, $competence->getNom());
        }

        $form = $this->createForm(MissionType::class, $mission, [
            'competencesChantier' => $competencesChantier,
            'dateDebut' => $chantier->getDebutTravaux(),
            'dateFin' => $chantier->getFinTravaux(),

        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mission->setChantier($chantier);
            $entityManager->persist($mission);
            $entityManager->flush();

            return $this->redirectToRoute('show_chantier', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission/new.html.twig', [
            'mission' => $mission,
            'id' => $id,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mission_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mission $mission, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission/edit.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mission_delete', methods: ['POST'])]
    public function delete(Request $request, Mission $mission, EntityManagerInterface $entityManager): Response
    {
        $chantierId = $mission->getChantier()->getId();

        if ($this->isCsrfTokenValid('delete'.$mission->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($mission);
            $entityManager->flush();
        }

        return $this->redirectToRoute('show_chantier', ['id' => $chantierId], Response::HTTP_SEE_OTHER);
    }
}
