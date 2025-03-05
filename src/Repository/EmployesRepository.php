<?php

namespace App\Repository;

use App\Entity\Employes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Employes>
 */
class EmployesRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employes::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Employes) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * Récupère tous les employés présents sur un chantier donné avec les informations de dates.
     *
     * @param int $chantierId
     * @return array
     */
    public function findEmployesByChantierId(int $chantierId): array
    {
        return $this->createQueryBuilder('e')
            ->innerJoin('e.missions', 'm')
            ->innerJoin('m.chantier', 'c')
            ->where('c.id = :chantierId')
            ->setParameter('chantierId', $chantierId)
            ->select('e.nom as nomEmploye', 'e.prenom as prenomEmploye', 'm.dateDebut as debutMission', 'm.dateFin as finMission', 'm.id as missionId')
            ->getQuery()
            ->getResult();
    }

    public function findAllEmployesByCompetence(array $required_competences): array
    {
        return $this->createQueryBuilder('e')
            ->select('e.nom AS employe_nom, e.id')  
            ->join('e.competences', 'c')  
            ->where('c.nom IN (:competences)') 
            ->setParameter('competences', $required_competences)  
            ->getQuery()
            ->getArrayResult();  
    }


}
