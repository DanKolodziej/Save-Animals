<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserType", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Person", mappedBy="user", cascade={"persist", "remove"})
     */
    private $person;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\AnimalShelter", mappedBy="user", cascade={"persist", "remove"})
     */
    private $animalShelter;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Administrator", mappedBy="user", cascade={"persist", "remove"})
     */
    private $administrator;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Animal", mappedBy="owner")
     */
    private $animals;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
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

    public function getType(): ?UserType
    {
        return $this->type;
    }

    public function setType(?UserType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(Person $person): self
    {
        $this->person = $person;

        // set the owning side of the relation if necessary
        if ($person->getUser() !== $this) {
            $person->setUser($this);
        }

        return $this;
    }

    public function getAnimalShelter(): ?AnimalShelter
    {
        return $this->animalShelter;
    }

    public function setAnimalShelter(AnimalShelter $animalShelter): self
    {
        $this->animalShelter = $animalShelter;

        // set the owning side of the relation if necessary
        if ($animalShelter->getUser() !== $this) {
            $animalShelter->setUser($this);
        }

        return $this;
    }

    public function getAdministrator(): ?Administrator
    {
        return $this->administrator;
    }

    public function setAdministrator(Administrator $administrator): self
    {
        $this->administrator = $administrator;

        // set the owning side of the relation if necessary
        if ($administrator->getUser() !== $this) {
            $administrator->setUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Animal[]
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): self
    {
        if (!$this->animals->contains($animal)) {
            $this->animals[] = $animal;
            $animal->setOwner($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): self
    {
        if ($this->animals->contains($animal)) {
            $this->animals->removeElement($animal);
            // set the owning side to null (unless already changed)
            if ($animal->getOwner() === $this) {
                $animal->setOwner(null);
            }
        }

        return $this;
    }
}
