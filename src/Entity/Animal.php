<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnimalRepository")
 */
class Animal {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Zwierzak musi mieć imię")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Species", inversedBy="animals")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Nie wybrano gatunek")
     */
    private $species;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="animals")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Zwierzak musi mieć właściciela")
     */
    private $owner;

    /**
     * @ORM\Column(type="string", length=8)
     * @Assert\Choice(choices={"adoption", "wanted", "lost", "found"},
     *     message="Wybierz prawidłową kategorię dla zwierzaka")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageFileName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSpecies(): ?Species
    {
        return $this->species;
    }

    public function setSpecies(?Species $species): self
    {
        $this->species = $species;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getImageFileName()
    {
        return $this->imageFileName;
    }

    public function setImageFileName($imageFileName)
    {
        $this->imageFileName = $imageFileName;

        return $this;
    }
}
