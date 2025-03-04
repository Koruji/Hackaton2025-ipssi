<?php

namespace App\Controller;

use App\Entity\Chantier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/dashboard', name: 'app_home_admin')]
    public function index(EntityManagerInterface $em): Response
    {
        $chantiers = $em->getRepository(Chantier::class)->findAll();
        return $this->render('home/index.html.twig', [
            'chantiers' => $chantiers,
            'controller_name' => 'HomeController',
        ]);
    }
}