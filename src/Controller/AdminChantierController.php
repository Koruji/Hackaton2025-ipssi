<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminChantierController extends AbstractController
{
    #[Route('/admin/chantier', name: 'app_admin_chantier')]
    public function index(): Response
    {
        return $this->render('admin_chantier/index.html.twig', [
            'controller_name' => 'AdminChantierController',
        ]);
    }
}
