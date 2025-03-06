<?php

namespace App\Repository;

use App\Entity\Mission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mission>
 */
class MissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mission::class);
    }

    /**
     * Récupère toutes les missions d'un chantier donné avec les informations de dates.
     *
     * @param int $chantierId
     * @return array
     */
    public function findMissionsByChantierId(int $chantierId): array
    {
        return $this->createQueryBuilder('m')
            ->innerJoin('m.chantier', 'c')
            ->innerJoin('m.employe', 'e')
            ->leftJoin('e.competence', 'comp')
            ->where('c.id = :chantierId')
            ->setParameter('chantierId', $chantierId)
            ->select('m', 'e.nom', 'e.prenom')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Mission[] Returns an array of Mission objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Mission
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
