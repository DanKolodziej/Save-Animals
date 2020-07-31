<?php

namespace App\Service;

use App\Repository\EndangeredSpeciesRepository;

class EndangeredSpeciesFetcher {

    private $endangeredSpeciesRepository;

    public function __construct(EndangeredSpeciesRepository $endangeredSpeciesRepository) {
        $this->endangeredSpeciesRepository = $endangeredSpeciesRepository;
    }

    public function getEndangeredSpecies() {
        return $this->endangeredSpeciesRepository->findAll();
    }

    public function getEndangeredSpeciesByType($type) {
        return $this->endangeredSpeciesRepository->findByEndangeredSpeciesType($type);
    }

    public function getEndangeredSpeciesByName($name) {
        return $this->endangeredSpeciesRepository->findOneByName($name);
    }
}