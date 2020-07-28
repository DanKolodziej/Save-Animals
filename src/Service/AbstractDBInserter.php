<?php

namespace App\Service;

use Doctrine\Persistence\ObjectManager;

abstract class AbstractDBInserter {

    protected $objectManager;

    public function __construct(ObjectManager $objectManager) {
        $this->objectManager = $objectManager;
    }

    public function insert(object $entity) {
        $entityManager = $this->objectManager;
        $entityManager->persist($entity);
        $entityManager->flush();
    }
}