<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offre>
 */
class OffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offre::class);
    }

    public function findAllStages()
    {
        return $this->createQueryBuilder('o')
            ->join('o.ref_typeOffre', 't')
            ->where('t.nom = :type')
            ->setParameter('type', 'Stages')
            ->getQuery()
            ->getResult();
    }

    public function findStagesByEntreprise($entrepriseId)
    {
        return $this->createQueryBuilder('o')
            ->join('o.ref_EntrepriseCreer', 'e') // Supposons que 'refEntreprises' est la propriété ManyToMany
            ->join('o.ref_typeOffre', 't')
            ->where('t.nom = :type')
            ->andWhere('e.id = :entrepriseId') // Condition pour l'entreprise
            ->setParameter('type', 'Stages')
            ->setParameter('entrepriseId', $entrepriseId)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Offre[] Returns an array of Offre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Offre
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
