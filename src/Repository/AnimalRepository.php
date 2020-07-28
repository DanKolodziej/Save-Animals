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
            ->andWhere('o.province LIKE :province')
            ->setParameter('province', '%' . $province . '%')
            ->andWhere('o.city LIKE :city')
            ->setParameter('city', '%' . $city . '%')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findRandomAnimals($amount) {
        $connection = $this->getEntityManager()->getConnection();

        $sql = 'SELECT id, name, description, category, image_file_name
                FROM animal 
                ORDER BY RAND()
                LIMIT '. $amount;

        $stmt = $connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
