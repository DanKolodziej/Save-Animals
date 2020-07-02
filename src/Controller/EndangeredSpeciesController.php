<?php

namespace App\Controller;

use App\Service\EndangeredSpeciesScraper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EndangeredSpeciesController extends AbstractController {

    /**
     * @Route("/endangered-species-data", name="endangeredSpeciesData", methods={"GET"})
     */
    public function endangeredSpecies(EndangeredSpeciesScraper $endangeredSpeciesScraper): JsonResponse
    {
        $endangeredSpeciesScraper->makeRequest();
        $endangeredSpeciesData = $endangeredSpeciesScraper->extractEndangeredAnimalSpecies();

        $serializer = new Serializer([new ObjectNormalizer()]);

        $data = $serializer->normalize($endangeredSpeciesData, null, [AbstractNormalizer::ATTRIBUTES => ['name', 'description', 'imageLink']]);

        return new JsonResponse($data);
    }
}
