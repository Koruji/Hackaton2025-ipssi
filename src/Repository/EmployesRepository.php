<?php

namespace App\Repository;

use App\Entity\Employes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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

    //by Soumaya
    public function findAllEmployesByCompetence(array $required_competences)
    {
        return $this->createQueryBuilder('e')
            ->join('e.competence', 'c')
            ->where('c.nom IN (:competences)')
            ->setParameter('competences', $required_competences);
    }

    public function findEmployesByRole(): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.roles LIKE :role')
            ->setParameter('role', '%ROLE_USER%')
            ->innerJoin('e.competence', 'c')
            ->addSelect('c')
            ->getQuery()
            ->getArrayResult();  
    }


    public function findAvailableEmployes(array $requiredCompetences, \DateTime $dateDebut, \DateTime $dateFin)
    {
        return $this->createQueryBuilder('e')
            // Rechercher les employés avec le rôle ROLE_USER
            ->where('e.roles LIKE :role')
            ->setParameter('role', '%ROLE_USER%')

            // Faire le lien avec les compétences nécessaire pour le chantier
            ->innerJoin('e.competence', 'c')
            ->addSelect('c')
            ->andWhere('c.nom IN (:competences)')
            ->setParameter('competences', $requiredCompetences)

            // Exclure les employés qui ont une mission chevauchante
            ->leftJoin('e.missions', 'm')
            ->andWhere('e.id NOT IN (
                SELECT emp.id FROM App\Entity\Employes emp
                JOIN emp.missions miss
                WHERE miss.dateDebut < :dateFin AND miss.dateFin > :dateDebut
            )')
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin);
    }

    //    /**
    //     * @return Employes[] Returns an array of Employes objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }


}
