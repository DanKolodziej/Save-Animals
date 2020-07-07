<?php

namespace App\Controller;

use App\Entity\Species;
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
    public function getSpecies(): JsonResponse {
        $species = $this->getDoctrine()->getRepository(Species::class)->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);

        $data = $serializer->normalize($species, null, [AbstractNormalizer::ATTRIBUTES => ['id', 'name', 'nameSingular']]);

        return new JsonResponse($data);
    }
}
