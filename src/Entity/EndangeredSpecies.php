<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EndangeredSpeciesRepository")
 */
class EndangeredSpecies implements JsonSerializable {

    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

     /**
      * @var string
      *
      * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $endangeredSpeciesType;

     /**
      * @var string
      *
      * @ORM\Column(type="string", length=255)
     */
    private $imageLink;

    public function __construct(string $name, string $description, string $endangeredSpeciesType, string $imageLink) {
        $this->name = $name;
        $this->description = $description;
        $this->endangeredSpeciesType = $endangeredSpeciesType;
        $this->imageLink = $imageLink;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    /**
     * @param string $name
     * @return EndangeredSpecies
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    /**
     * @param string $description
     * @return EndangeredSpecies
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEndangeredSpeciesType(): ?string {
        return $this->endangeredSpeciesType;
    }

    /**
     * @param string $endangeredSpeciesType
     * @return EndangeredSpecies
     */
    public function setEndangeredSpeciesType(string $endangeredSpeciesType): self
    {
        $this->endangeredSpeciesType = $endangeredSpeciesType;

        return $this;
    }

    public function getImageLink(): ?string {
        return $this->imageLink;
    }

    /**
     * @param string $imageLink
     * @return EndangeredSpecies
     */
    public function setImageLink(string $imageLink): self
    {
        $this->imageLink = $imageLink;

        return $this;
    }

    public function jsonSerialize() {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'endangeredSpeciesType' => $this->endangeredSpeciesType,
            'imageLink' => $this->imageLink
        ];
    }
}