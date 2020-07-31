<?php

namespace App\Service;

use Doctrine\Persistence\ObjectManager;

class EndangeredSpeciesInserter extends AbstractDBInserter {

    public function __construct(ObjectManager $objectManager) {
        parent::__construct($objectManager);
    }
}