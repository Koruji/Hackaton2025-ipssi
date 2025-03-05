<?php

namespace App\Controller;

use App\Entity\Chantier;
use App\Form\ChantierType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AdminChantierController extends AbstractController
{
    #[Route('/admin/chantier', name: 'app_admin_chantier')]
    public function index(EntityManagerInterface $em): Response
    {
        $chantiers = $em->getRepository(Chantier::class)->findAll();

        return $this->render('chantier_test/index.html.twig', [
            'chantiers' => $chantiers,
        ]);
    }


    #[Route('/admin/chantier/new', name: 'app_chantier_new', methods: ['GET', 'POST'])]
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

        return $this->render('admin/chantier_test/new.html.twig', [
            'chantier' => $chantier,
            'form' => $form->createView(),
        ]);
    }
}
