<?php

namespace App\Controller;

use App\Entity\Employes;
use App\Form\EmployesType;
use App\Repository\EmployesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/employes')]
final class EmployesController extends AbstractController
{
    #[Route(name: 'app_employes_index', methods: ['GET'])]
    public function index(EmployesRepository $employesRepository): Response
    {
        return $this->render('employes/index.html.twig', [
            'employes' => $employesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_employes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $employe = new Employes();
        $form = $this->createForm(EmployesType::class, $employe, [
            'password' => true,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employe->setRoles(['ROLE_USER']);
            $employe->setDisponible(true);

            $password = $form->get('password')->getData();
            $employe->setPassword($userPasswordHasher->hashPassword($employe, $password));

            $entityManager->persist($employe);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_ouvrier', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('employes/new.html.twig', [
            'employe' => $employe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employes_show', methods: ['GET'])]
    public function show(Employes $employe): Response
    {
        return $this->render('employes/show.html.twig', [
            'employe' => $employe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_employes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Employes $employe, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(EmployesType::class, $employe, [
            'password' => false,
            'help' => '(Laissez ce champ vide si vous ne souhaitez pas modifier le mot de passe.)',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employe->setNom($form->get('nom')->getData());
            $employe->setPrenom($form->get('prenom')->getData());
            $employe->setEmail($form->get('email')->getData());

            $password = $form->get('password')->getData();

            if ($password) {
                $employe->setPassword($userPasswordHasher->hashPassword($employe, $password));
            } else {
                $employe->setPassword($employe->getPassword());
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_ouvrier', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('employes/edit.html.twig', [
            'employe' => $employe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employes_delete', methods: ['POST'])]
    public function delete(Request $request, Employes $employe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employe->getId(), $request->getPayload()->getString('_token'))) {
            $missions = $employe->getMissions();
            foreach ($missions as $mission) {
                $entityManager->remove($mission);
            }
            $entityManager->remove($employe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_ouvrier', [], Response::HTTP_SEE_OTHER);
    }
}
