<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @Route("/adopcja", name="adoption")
     * @Route("/zaginione-zwierzaki", name="lostAnimals")
     * @Route("/zagrozone-gatunki", name="endangeredSpecies")
     * @Route("/blog", name="blog")
     * @Route("/zaloguj", name="singIn")
     */
    public function main()
    {
        return $this->render('main/main.html.twig');
    }
}
