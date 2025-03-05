<?php

namespace App\Controller;

use App\Entity\Chantier;
use App\Entity\Employes;
use App\Form\ChantierType;
use App\Repository\ChantierRepository;
use App\Repository\CompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/chantier')]
final class ChantierController extends AbstractController
{
    #[Route('/chantier/{id}', name: 'show_chantier')] //utilisé pour quand on clique sur un chantier dashboard
    public function show(EntityManagerInterface $em, $id): Response
    {
        $chantier = $em->getRepository(Chantier::class)->find($id);
        $ouvriers = $em->getRepository(Employes::class)->findEmployesByChantierId($id);
        return $this->render('chantier/show.html.twig', [
            'chantier' => $chantier,
            'ouvriers' => $ouvriers
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

            return $this->redirectToRoute('app_admin_chantier', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chantier/new.html.twig', [
            'chantier' => $chantier,
            'form' => $form,
        ]);
    }

   
    #[Route('/{id}/edit', name: 'app_chantier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chantier $chantier, EntityManagerInterface $entityManager, CompetenceRepository $competenceRepository): Response
    {
        $form = $this->createForm(ChantierType::class, $chantier);
        $form->handleRequest($request);

        $competences = $competenceRepository->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_chantier', [], Response::HTTP_SEE_OTHER);
        }

        if ($request->isMethod('POST') && $request->request->get('form_type') === 'add_competence') {
            $competenceId = $request->request->get('competence');

            if (!empty($competenceId)) {
                $competence = $competenceRepository->find($competenceId);

                if ($competence) {
                    $chantier->addCompetence($competence);
                    $entityManager->flush();

                    $this->addFlash('success', 'Compétence ajoutée au chantier avec succès !');
                } else {
                    $this->addFlash('error', 'Compétence introuvable.');
                }
            } else {
                $this->addFlash('error', 'Veuillez sélectionner une compétence valide.');
            }

            return $this->redirectToRoute('app_admin_chantier', ['id' => $chantier->getId()]);
        }

        return $this->render('chantier/edit.html.twig', [
            'chantier' => $chantier,
            'form' => $form->createView(),
            'competences' => $competences,  
        ]);
    }



    // #[Route('/{id}/edit', name: 'app_chantier_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Chantier $chantier, EntityManagerInterface $entityManager, CompetenceRepository $competenceRepository): Response
    // {
    //     //insertion en bdd de la competence + chantier
    //     if ($request->isMethod('POST')) {
    //         $competenceId = $request->request->get('competence');
    //         $competence = $competenceRepository->find($competenceId);

    //         if ($competence) {
    //             $chantier = new Chantier();
    //             $chantier->addCompetence($competence);
    //             $entityManager->persist($chantier);
    //             $entityManager->flush();

    //             $this->addFlash('success', 'Compétence ajoutée au chantier avec succès !');
    //         } else {
    //             $this->addFlash('error', 'Compétence introuvable.');
    //         }
    //         return $this->redirectToRoute('show_chantier', ['id' => $id]);
    //     }

    //     $competences = $competenceRepository->findAllCompetences();

    //     $form = $this->createForm(ChantierType::class, $chantier);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_admin_chantier', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('chantier/edit.html.twig', [
    //         'chantier' => $chantier,
    //         'form' => $form,
    //         'competences' => $competences
    //     ]);
    // }

    #[Route('/{id}', name: 'app_chantier_delete', methods: ['POST'])]
    public function delete(Request $request, Chantier $chantier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chantier->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($chantier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_chantier', [], Response::HTTP_SEE_OTHER);
    }
}
