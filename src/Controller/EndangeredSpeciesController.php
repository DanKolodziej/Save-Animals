<?php

namespace App\Controller;

use App\Service\EndangeredSpeciesScraper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class EndangeredSpeciesController extends AbstractController {

    /**
     * @Route("/endangered-species-data", name="endangeredSpeciesData", methods={"GET"})
     */
    public function endangeredSpecies(EndangeredSpeciesScraper $endangeredSpeciesScraper): JsonResponse
    {
        $endangeredSpeciesScraper->makeRequest();
        $endangeredSpeciesData = $endangeredSpeciesScraper->extractEndangeredSpeciesData();
        return new JsonResponse($endangeredSpeciesData);
    }
}
