<?php

namespace App\DataFixtures;

use App\Entity\Species;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SpeciesFixtures extends Fixture
{
    private $speciesNames;
    private $speciesNamesSingular;

    public function __construct()
    {
        $this->speciesNames = array(
            ['Psy', 'Pies'], ['Koty', 'Kot'], ['Chomiki', 'Chomik'],
            ['Świnki morskie', 'Świnka morska'], ['Króliki', 'Królik'],
            ['Myszy', 'Mysz'], ['Szczury', 'Szczur'], ['Szynszyle', 'Szynszyla'],
            ['Koszatniczki', 'Koszatniczka'], ['Tchórzofretki', 'Tchórzofretka'],
            ['Jaszczurki', 'Jaszczurka'], ['Żółwie', 'Żółw'], ['Węże', 'Wąż'], ['Żaby', 'Żaba'],
            ['Salamandry', 'Salamandra'], ['Ptaki', 'Ptak'], ['Pająki', 'Pająk'],
            ['Owady', 'Owad'], ['Bezkręgowce', 'Bezkręgowiec'], ['Ryby', 'Ryba'], ['Inne', 'Inne']);
    }

    public function load(ObjectManager $manager)
    {

        foreach ($this->speciesNames as $speciesName) {
            $species = New Species();
            $species->setName($speciesName[0]);
            $species->setNameSingular($speciesName[1]);
            $manager->persist($species);
        }

        $manager->flush();
    }
}
