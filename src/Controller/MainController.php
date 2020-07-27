<?php

namespace App\Controller;

use App\Service\EntityNormalizer;
use App\Service\UserNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class MainController extends AbstractController {

    /**
     * @Route("/", name="index")
     * @Route("/adopcja", name="adoption")
     * @Route("/zaginione-zwierzaki", name="lostAnimals")
     * @Route("/zwierzak/{id}", name="animalPage")
     * @Route("/zagrozone-gatunki", name="endangeredSpecies")
     * @Route("/zagrozony-gatunek/{id}", name="endangeredSpeciesPage")
     * @Route("/zwierzaki-uzytkownika", name="userAnimals")
     * @Route("/zwierzaki-uzytkownika/{id}", name="userAnimalsById")
     * @Route("/blog", name="blog")
     * @Route("/logowanie", name="singIn")
     * @Route("/rejestracja", name="singUp")
     */
    public function main(EntityNormalizer $entityNormalizer) {

        $user = $entityNormalizer->normalize($this->getUser(), ['id', 'email', 'name']);

        return $this->render('main/main.html.twig', [
            'isAuthenticated' => json_encode(!empty($user)),
            'user' => json_encode($user) ?? ''
        ]);
    }
}
