<?php

namespace App\DataFixtures;

use App\Entity\Species;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SpeciesFixtures extends Fixture
{
    private $speciesNames;

    public function __construct()
    {
        $this->speciesNames = array('Psy', 'Koty', 'Chomiki', 'Świnki morskie',
            'Króliki', 'Myszy', 'Szczury', 'Szynszyle',
            'Koszatniczki', 'Tchórzofretki', 'Świnie',
            'Jaszczurki', 'Żółwie', 'Węże', 'Żaby',
            'Salamandry', 'Ptaki', 'Pająki', 'Owady',
            'Bezkręgowce', 'Ryby', 'Inne');
    }

    public function load(ObjectManager $manager)
    {

        foreach ($this->speciesNames as $speciesName) {
            $species = New Species();
            $species->setName($speciesName);
            $manager->persist($species);
        }

        $manager->flush();
    }
}
