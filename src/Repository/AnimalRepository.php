<?php

namespace App\Repository;

use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Animal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animal[]    findAll()
 * @method Animal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Animal::class);
    }

    public function filter($category, $species, $name, $description, $province, $city) {
        return $this->createQueryBuilder('a')
            ->join('a.species', 's')
            ->join('a.owner', 'o')
            ->andWhere('a.category = :category')
            ->setParameter('category', $category)
            ->andWhere('s.name LIKE :species')
            ->setParameter('species', '%' . $species. '%')
            ->andWhere('a.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->andWhere('a.description LIKE :description')
            ->setParameter('description', '%' . $description . '%')
            ->andWhere('o.province = :province')
            ->setParameter('province', $province)
            ->andWhere('o.city LIKE :city')
            ->setParameter('city', '%' . $city . '%')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findThreeRandomAnimals() {
        $connection = $this->getEntityManager()->getConnection();

        $sql = 'SELECT id, name, description, image_file_name
                FROM animal 
                ORDER BY RAND()
                LIMIT 3';

        $stmt = $connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // /**
    //  * @return Animal[] Returns an array of Animal objects
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
    public function findOneBySomeField($value): ?Animal
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
