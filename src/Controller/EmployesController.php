<?php

namespace App\Controller;

use App\Entity\Chantier;
use App\Entity\Employes;
use App\Entity\Competence;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EmployesController extends AbstractController
{
    #[Route('/employes', name: 'employe_list')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $competenceId = $request->query->get('competence');

        $competences = $em->getRepository(Competence::class)->findAll();
        $query = $em->getRepository(Employes::class)->createQueryBuilder('e');

        if ($competenceId) {
            $query->join('e.competences', 'c')
                  ->where('c.id = :competenceId')
                  ->setParameter('competenceId', $competenceId);
        }

        $employes = $query->getQuery()->getResult();

        return $this->render('employe/index.html.twig', [
            'employes' => $employes,
            'competences' => $competences,
        ]);
    }
}
