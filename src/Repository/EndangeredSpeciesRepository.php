<?php

namespace App\Repository;

use App\Entity\EndangeredSpecies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EndangeredSpecies|null find($id, $lockMode = null, $lockVersion = null)
 * @method EndangeredSpecies|null findOneBy(array $criteria, array $orderBy = null)
 * @method EndangeredSpecies[]    findAll()
 * @method EndangeredSpecies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EndangeredSpeciesRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, EndangeredSpecies::class);
    }
}