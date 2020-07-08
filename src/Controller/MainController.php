<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class MainController extends AbstractController
{
    /** @var SerializerInterface */
    private $serializer;

    public function __construct(SerializerInterface $serializer) {
        $this->serializer = $serializer;
    }

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
    public function main() {
        $serializer = new Serializer([new ObjectNormalizer()]);

        $data = null;
        if($this->getUser()) {
            $data = $serializer->normalize($this->getUser(), null, [AbstractNormalizer::ATTRIBUTES => ['id', 'email', 'name']]);
        }
        
        return $this->render('main/main.html.twig', [
            'isAuthenticated' => json_encode(!empty($data)),
            'user' => json_encode($data) ?? ''
        ]);
    }
}
