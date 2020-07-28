<?php

namespace App\Controller;

use App\Service\EntityNormalizer;
use App\Service\SpeciesFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SpeciesController extends AbstractController {
    /**
     * @Route("/species", name="getSpecies", methods={"GET"})
     */
    public function getSpecies(SpeciesFetcher $speciesFetcher, EntityNormalizer $entityNormalizer): JsonResponse {
        $species = $speciesFetcher->getAllSpecies();
        $speciesNormalized = $entityNormalizer->normalize($species, ['id', 'name', 'nameSingular']);

        return new JsonResponse($speciesNormalized);
    }
}
