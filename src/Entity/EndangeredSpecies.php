<?php

namespace App\Entity;

use JsonSerializable;

class EndangeredSpecies implements JsonSerializable {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

     /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $endangeredSpeciesType;

     /**
     * @var string
     */
    private $imageLink;

    public function __construct(string $name, string $description, string $imageLink) {
        $this->name = $name;
        $this->description = $description;
        $this->imageLink = $imageLink;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getImageLink(): string {
        return $this->imageLink;
    }

    public function jsonSerialize() {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'imageLink' => $this->imageLink
        ];
    }
}