<?php

namespace App\Controller;

use App\Entity\Species;
use App\Service\EntityNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SpeciesController extends AbstractController
{
    /**
     * @Route("/species", name="getSpecies", methods={"GET"})
     */
    public function getSpecies(EntityNormalizer $entityNormalizer): JsonResponse {
        $species = $this->getDoctrine()->getRepository(Species::class)->findAll();
        $speciesNormalized = $entityNormalizer->normalize($species, ['id', 'name', 'nameSingular']);

        return new JsonResponse($speciesNormalized);
    }
}
