<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\AnimalRepository;

class AnimalFetcher {

    private $animalRepository;

    public function __construct(AnimalRepository $animalRepository) {
        $this->animalRepository = $animalRepository;
    }

    /**
     * @param User $user
     * @param string $category
     * @return \App\Entity\Animal[]
     */
    public function getAnimalsByUserAndCategory(User $user, string $category): ?array {
        return $this->animalRepository->findBy(['owner' => $user, 'category' => $category]);
    }

    /**
     * @return \App\Entity\Animal[]
     */
    public function filterAnimals($category, $species, $name, $description, $province, $city): ?array {
        return $this->animalRepository->filter($category, $species, $name, $description, $province, $city);
    }

    /**
     * @return \App\Entity\Animal[]
     */
    public function getRandomAnimals($amount): ?array {
        return $this->animalRepository->findRandomAnimals($amount);
    }

    /**
     * @param int $id
     * @return \App\Entity\Animal
     */
    public function getAnimal(int $id): ?\App\Entity\Animal {
        return $this->animalRepository->find($id);
    }
}