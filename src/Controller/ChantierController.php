<?php

namespace App\Controller;

use App\Entity\Chantier;
use App\Entity\Employes;
use App\Form\ChantierType;
use App\Repository\ChantierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EmployesRepository;
use App\Entity\Competence;

#[Route('/chantier')]
final class ChantierController extends AbstractController
{
  
    #[Route('/{id}', name: 'show_chantier')] //utilisé pour quand on clique sur un chantier dashboard
    public function show(EntityManagerInterface $em, $id): Response

    {
        //données statique : à remplacer par les vraies
        $required_competences = ["Électricité", "Travaux de finition"];

        $employes_filtered = $employesRepository->findAllEmployesByCompetence($required_competences);

        $chantier = $em->getRepository(Chantier::class)->find($id);
        $ouvriers = $em->getRepository(Employes::class)->findEmployesByChantierId($id);
        return $this->render('chantier/show.html.twig', [
            'chantier' => $chantier,
            'ouvriers' => $ouvriers,
            'competences' => $required_competences,
            'ouvriers_possible' => $employes_filtered

        ]);
    }

    #[Route(name: 'app_chantier_index', methods: ['GET'])]
    public function index(ChantierRepository $chantierRepository): Response
    {
        return $this->render('chantier/index.html.twig', [
            'chantiers' => $chantierRepository->findAll(),
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

            return $this->redirectToRoute('app_chantier_index', [], Response::HTTP_SEE_OTHER);
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

            return $this->redirectToRoute('app_chantier_index', [], Response::HTTP_SEE_OTHER);
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
            $entityManager->remove($chantier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_chantier_index', [], Response::HTTP_SEE_OTHER);
    }
}
