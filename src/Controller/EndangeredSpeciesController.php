<?php

namespace App\Controller;

use App\Service\EndangeredSpeciesScraper;
use App\Service\EntityNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class EndangeredSpeciesController extends AbstractController {

    /**
     * @Route("/endangered-species-data", name="endangeredSpeciesData", methods={"GET"})
     */
    public function endangeredSpecies(
        EndangeredSpeciesScraper $endangeredSpeciesScraper,
        EntityNormalizer $entityNormalizer): JsonResponse {

        $endangeredSpeciesScraper->makeRequest();
        $endangeredSpeciesData = $endangeredSpeciesScraper->extractEndangeredAnimalSpecies();

        $endangeredSpeciesDataNormalized = $entityNormalizer->normalize($endangeredSpeciesData, [
            'name',
            'description',
            'endangeredSpeciesType',
            'imageLink']);

        return new JsonResponse($endangeredSpeciesDataNormalized);
    }

    /**
     * @Route("/singular-endangered-species-data/{name}", name="endangeredSpeciesDataByName", methods={"GET"})
     */
    public function endangeredSpeciesByName(
        string $name,
        EndangeredSpeciesScraper $endangeredSpeciesScraper,
        EntityNormalizer $entityNormalizer): JsonResponse {

        $endangeredSpeciesScraper->makeRequest();
        $endangeredSpeciesData = $endangeredSpeciesScraper->extractEndangeredAnimalSpeciesByName($name);

        $endangeredSpeciesDataNormalized = $entityNormalizer->normalize($endangeredSpeciesData, [
            'name',
            'description',
            'endangeredSpeciesType',
            'imageLink']);

        return new JsonResponse($endangeredSpeciesDataNormalized);
    }
}
