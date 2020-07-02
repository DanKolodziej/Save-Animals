<?php

namespace App\Service;

use Goutte\Client as GoutteClient;
use App\Entity\EndangeredSpecies;

class EndangeredSpeciesScraper {

    private $client;
    private $crawler;
    private $endangeredSpeciesTypes;
    private $endangeredAnimalSpecies;

    public function __construct(GoutteClient $goutteClient) {
        $this->client = $goutteClient;
    }

    public function makeRequest() {
        $this->crawler = $this->client->request('GET', 'https://pl.wikipedia.org/wiki/Polska_czerwona_ksi%C4%99ga_zwierz%C4%85t');
    }

    public function extractEndangeredAnimalSpecies() {
        $this->endangeredSpeciesTypes = [];
        $this->endangeredAnimalSpecies = [];
        
        $this->crawler->filter('ol > li')->each(function($endangeredType) {
            $endangeredSpeciesType = $endangeredType->filter('b')->text();
            $endangeredSpeciesType = explode(' – ', $endangeredSpeciesType)[0];
            $this->endangeredSpeciesTypes[] = $endangeredSpeciesType;
            $endangeredSpecies = $this->endangeredAnimalSpecies;
            $this->endangeredAnimalSpecies = [];
            $endangeredType->filter('dl > dd > a')->each(function($animal) {
                $link = $this->crawler->selectLink($animal->text())->link();
                $endangeredSpeciesPage = $this->client->click($link);
                $this->endangeredAnimalSpecies[] = new EndangeredSpecies(
                    $animal->text(),
                    preg_replace('/\[\d+\]/', '', implode(' ', $endangeredSpeciesPage->filter('.mw-parser-output > p')->each(function($paragraph) {
                        return $paragraph->text();
                    }))),
                    $endangeredSpeciesPage->filter('.image:first-child > img')->eq(0)->attr('src'));
            });
            $endangeredSpecies[] = $this->endangeredAnimalSpecies;
            $this->endangeredAnimalSpecies = $endangeredSpecies;
        });

        return array_combine($this->endangeredSpeciesTypes, $this->endangeredAnimalSpecies);
    }
}