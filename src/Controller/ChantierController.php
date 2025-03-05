<?php

namespace App\Controller;

use App\Entity\Chantier;
use App\Entity\Employes;
use App\Controller\EmployesController;
use App\Entity\Mission;
use App\Form\ChantierType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CompetenceRepository;
use App\Entity\Competence;

final class ChantierController extends AbstractController
{

    #[Route('/chantier/{id}', name: 'show_chantier')] //utilisé pour quand on clique sur un chantier dashboard
    public function show(EntityManagerInterface $em, $id, CompetenceRepository $competenceRepository): Response
    {
        //données statique : à remplacer par les vraies
        $required_competences = ["Électricité", "Travaux de finition"];

        $employes_filtered = $competenceRepository->findAllEmployesByCompetence($required_competences);

        $chantier = $em->getRepository(Chantier::class)->find($id);
        $ouvriers = $em->getRepository(Employes::class)->findEmployesByChantierId($id);
        return $this->render('chantier/show.html.twig', [
            'chantier' => $chantier,
            'ouvriers' => $ouvriers,
            'competences' => $required_competences,
            'ouvriers_possible' => $employes_filtered

        ]);
    }

    #[Route('/chantier/ajouter', name: 'chantier_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $chantier = new Chantier();
        $form = $this->createForm(ChantierType::class, $chantier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($chantier);
            $em->flush();
            return $this->redirectToRoute('chantier_list');
        }

        return $this->render('chantier/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/chantier/supprimer/{id}', name: 'chantier_delete')]
    public function delete(Chantier $chantier, EntityManagerInterface $em): Response
    {
        $em->remove($chantier);
        $em->flush();
        return $this->redirectToRoute('chantier_list');
    }

    #[Route('/chantier/modifier/{id}', name: 'chantier_edit')]
    public function edit(Request $request, Chantier $chantier, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ChantierType::class, $chantier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('chantier_list');
        }

        return $this->render('chantier/edit.html.twig', [
            'form' => $form->createView(),
            'chantier' => $chantier,
            'employes' => $chantier->getEmployes(),
        ]);
    }

    #[Route('/chantier/statut/{id}', name: 'chantier_status')]
    public function updateStatus(Chantier $chantier, EntityManagerInterface $em): Response
    {
        $chantier->setStatus($chantier->getStatus() === 'Fini' ? 'En cours' : 'Fini');
        $em->flush();

        return $this->redirectToRoute('chantier_list');
    }

    #[Route('/chantier/{id}/assigner', name: 'chantier_assign', methods: ['GET', 'POST'])]
    public function assigner(Request $request, Chantier $chantier, EntityManagerInterface $em): Response
    {
        $employes = $em->getRepository(Employes::class)->findAll();

        if ($request->isMethod('POST')) {
            $employeIds = $request->request->get('employes');
            
            $selectedEmployes = $em->getRepository(Employes::class)->findBy(['id' => $employeIds]);

            foreach ($selectedEmployes as $employe) {
                if (!$chantier->getEmployes()->contains($employe)) {
                    $chantier->getEmployes()->add($employe);
                }
            }

            $em->persist($chantier);
            $em->flush();

            return $this->redirectToRoute('chantier_edit', ['id' => $chantier->getId()]);
        }

        return $this->render('chantier/assign.html.twig', [
            'chantier' => $chantier,
            'employes' => $employes,
        ]);
    }

}
