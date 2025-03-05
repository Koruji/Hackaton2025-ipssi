<?php

namespace App\Controller;

use App\Entity\Employes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminOuvrierController extends AbstractController
{
    #[Route('/admin/ouvrier', name: 'app_admin_ouvrier')]
    public function index(EntityManagerInterface $em): Response
    {
        $employes = $em->getRepository(Employes::class)->findAll();

        return $this->render('admin_ouvrier/index.html.twig', [
            'employes' => $employes,
        ]);
    }
}