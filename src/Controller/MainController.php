<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @Route("/zaloguj", name="singIn")
     * @Route("/adopcja", name="adoption")
     * @Route("/zagrozone-gatunki", name="endangeredSpecies")
     * @Route("/blog", name="blog")
     */
    public function main()
    {
        return $this->render('main/main.html.twig');
    }
}
