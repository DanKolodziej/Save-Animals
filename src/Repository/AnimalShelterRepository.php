<?php

namespace App\Repository;

use App\Entity\AnimalShelter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AnimalShelter|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimalShelter|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimalShelter[]    findAll()
 * @method AnimalShelter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalShelterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimalShelter::class);
    }

    // /**
    //  * @return AnimalShelter[] Returns an array of AnimalShelter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AnimalShelter
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
