<?php

namespace App\Controller;

use App\Entity\Chantier;
use App\Entity\Employes;
use App\Controller\EmployesController;
use App\Form\ChantierType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ChantierController extends AbstractController
{
    #[Route('/chantiers', name: 'chantier_list')]
    public function index(EntityManagerInterface $em): Response
    {
        $chantiers = $em->getRepository(Chantier::class)->findAll();

        return $this->render('chantier/index.html.twig', [
            'chantiers' => $chantiers,
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
