<?php

namespace App\Service;

use Goutte\Client as GoutteClient;

class EndangeredSpeciesScraper {

    private $client;
    private $crawler;
    private $endangeredSpeciesList;

    public function __construct(GoutteClient $goutteClient) {
        $this->client = $goutteClient;
    }

    public function makeRequest() {
        $this->crawler = $this->client->request('GET', 'https://pl.wikipedia.org/wiki/Polska_czerwona_ksi%C4%99ga_zwierz%C4%85t');
    }

    public function extractEndangeredSpeciesData() {
        $this->endangeredSpeciesList = [];
        $this->crawler->filter('ol > li')->each(function ($node) {
            $this->endangeredSpeciesList[] = $node->text();
        });

        return $this->endangeredSpeciesList;
    }
}