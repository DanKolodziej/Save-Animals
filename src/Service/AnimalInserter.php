<?php

namespace App\Service;

use App\Entity\Animal;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AnimalInserter extends AbstractDBInserter {

    private $imageUploader;

    public function __construct(
        ObjectManager $objectManager,
        ImageUploader $imageUploader) {

        parent::__construct($objectManager);
        $this->imageUploader = $imageUploader;
    }

    public function setProperties(Animal $animal, array $properties) {
        $animal->setName($properties['name']);
        $animal->setSpecies($properties['species']);
        $animal->setDescription($properties['description']);
        $animal->setCategory($properties['category']);
        $animal->setOwner($properties['user']);
        $animal->setContact($properties['contact']);
        if($properties['image']) {
            $this->setImage($animal, $properties['image']);
        }
    }

    private function setImage(Animal $animal, UploadedFile $image) {
        $newImageFileName = $this->imageUploader->upload($image);
        $animal->setImageFileName($newImageFileName);
    }
}