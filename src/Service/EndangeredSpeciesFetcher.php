<?php

namespace App\Service;

use App\Repository\EndangeredSpeciesRepository;

class EndangeredSpeciesFetcher {

    private $endangeredSpeciesRepository;

    public function __construct(EndangeredSpeciesRepository $endangeredSpeciesRepository) {
        $this->endangeredSpeciesRepository = $endangeredSpeciesRepository;
    }

    public function getEndangeredSpecies(): ?array {
        return $this->endangeredSpeciesRepository->findAll();
    }

    public function getEndangeredSpeciesByType($type): ?array {
        return $this->endangeredSpeciesRepository->findByEndangeredSpeciesType($type);
    }

    public function getEndangeredSpeciesByName($name): ?\App\Entity\EndangeredSpecies {
        return $this->endangeredSpeciesRepository->findOneByName($name);
    }
}