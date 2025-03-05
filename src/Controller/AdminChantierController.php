<?php

namespace App\Controller;

use App\Repository\ChantierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/chantier')]
final class AdminChantierController extends AbstractController
{
    #[Route('/', name: 'app_admin_chantier')]
    public function index(ChantierRepository $chantierRepository): Response
    {
        $chantiers = $chantierRepository->findAll();

        return $this->render('admin_chantier/index.html.twig', [
            'chantiers' => $chantiers,
        ]);
    }
}
