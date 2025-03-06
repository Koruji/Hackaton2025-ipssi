<?php

namespace App\Controller;

use App\Entity\Mission;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeUserController extends AbstractController
{
    #[Route('/home/user', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home_user/index.html.twig', [
            'controller_name' => 'HomeUserController',
        ]);
    }

    #[Route('/api/missions', name: 'api_calendar', methods: ['GET'])]
    public function getMissions(EntityManagerInterface $em): JsonResponse
    {
        $user = $this->getUser();

        $missions = $em->getRepository(Mission::class)->findMissionsByUser($user->getId());
        $data = array_map(function ($mission) {
            return [
                'id' => $mission->getId(),
                'title' => $mission->getChantier()->getNom(),
                'start' => $mission->getDateDebut()->format('Y-m-d'),
                'end' => $mission->getDateFin()->modify('+1 day')->format('Y-m-d'),
                'description' => $mission->getChantier()->getAdresse(),
            ];
        }, $missions);

        return $this->json($data);
    }
}
