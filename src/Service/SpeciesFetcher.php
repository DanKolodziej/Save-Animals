<?php

namespace App\Service;

use App\Repository\SpeciesRepository;

class SpeciesFetcher {

    private $speciesRepository;

    public function __construct(SpeciesRepository $speciesRepository) {
        $this->speciesRepository = $speciesRepository;
    }

    /**
     * @return \App\Entity\Species[]
     */
    public function getAllSpecies(): array
    {
        return $this->speciesRepository->findAll();
    }

    /**
     * @return \App\Entity\Species
     */
    public function getSpeciesByNameSingular($speciesName): \App\Entity\Species
    {
        return $this->speciesRepository->findOneByNameSingular($speciesName);
    }
}