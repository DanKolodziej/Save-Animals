<?php

namespace App\Controller;

use App\Entity\EndangeredSpecies;
use App\Service\EndangeredSpeciesFetcher;
use App\Service\EndangeredSpeciesInserter;
use App\Service\EndangeredSpeciesScraper;
use App\Service\EntityNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/update-endangered-species", name="updateEndangeredSpecies", methods={"POST"})
     */
    public function updateEndangeredSpecies(
        Request $request,
        EndangeredSpeciesInserter $endangeredSpeciesInserter): JsonResponse {

        $endangeredSpecies = $this->getDoctrine()
            ->getRepository(EndangeredSpecies::class)
            ->findAll();

        $entityManager = $this->getDoctrine()->getManager();
        foreach($endangeredSpecies as $singularEndangeredSpecies) {
            $entityManager->remove($singularEndangeredSpecies);
        }
        $entityManager->flush();

        $endangeredSpecies = $request->getContent();
        $endangeredSpecies = json_decode($endangeredSpecies, true)['endangeredSpecies'];
        foreach($endangeredSpecies as $singularEndangeredSpecies) {
            $newEndangeredSpecies = new EndangeredSpecies(
                $singularEndangeredSpecies['name'],
                $singularEndangeredSpecies['description'],
                $singularEndangeredSpecies['endangeredSpeciesType'],
                $singularEndangeredSpecies['imageLink']
            );
            $endangeredSpeciesInserter->insert($newEndangeredSpecies);
        }

        return new JsonResponse(['updated endangered species' => true]);
    }

    /**
     * @Route("/endangered-species", name="getEndangeredSpecies")
     */
    public function getEndangeredSpecies(
        EndangeredSpeciesFetcher $endangeredSpeciesFetcher,
        EntityNormalizer $entityNormalizer): JsonResponse {

        $endangeredSpecies = [];
        $endangeredSpecies['EX'] = $endangeredSpeciesFetcher->getEndangeredSpeciesByType('EX');
        $endangeredSpecies['EXP'] = $endangeredSpeciesFetcher->getEndangeredSpeciesByType('EXP');
        $endangeredSpecies['CR'] = $endangeredSpeciesFetcher->getEndangeredSpeciesByType('CR');
        $endangeredSpecies['EN'] = $endangeredSpeciesFetcher->getEndangeredSpeciesByType('EN');
        $endangeredSpecies['VU'] = $endangeredSpeciesFetcher->getEndangeredSpeciesByType('VU');
        $endangeredSpecies['NT'] = $endangeredSpeciesFetcher->getEndangeredSpeciesByType('NT');
        $endangeredSpecies['LC'] = $endangeredSpeciesFetcher->getEndangeredSpeciesByType('LC');
        $endangeredSpeciesNormalized = $entityNormalizer->normalize($endangeredSpecies, [
            'name',
            'description',
            'endangeredSpeciesType',
            'imageLink'
        ]);
        return new JsonResponse(['endangeredSpecies' => $endangeredSpeciesNormalized]);
    }

    /**
     * @Route("/endangered-species/{name}", name="getEndangeredSpeciesByName")
     */
    public function getEndangeredSpeciesByName(
        string $name,
        EndangeredSpeciesFetcher $endangeredSpeciesFetcher,
        EntityNormalizer $entityNormalizer): JsonResponse {

        $endangeredSpecies = $endangeredSpeciesFetcher->getEndangeredSpeciesByName($name);
        $endangeredSpeciesNormalized = $entityNormalizer->normalize($endangeredSpecies, [
            'name',
            'description',
            'endangeredSpeciesType',
            'imageLink'
        ]);
        return new JsonResponse(['endangeredSpecies' => $endangeredSpeciesNormalized]);
    }
}
