<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Email jest wymagane")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Hasło jest wymagane")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Imię/nazwa jest wymagana")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Choice({"Dolnośląskie", "Kujawsko-Pomorskie", "Lubelskie",
     *     "Lubuskie", "Łódzkie", "Małopolskie", "Mazowieckie",
     *     "Opolskie", "Podkarpackie", "Podlaskie",
     *     "Pomorskie", "Ślaskie", "Świętokrzyskie",
     *     "Warmińsko-Mazurskie", "Wielkopolskie", "Zachodniopomorskie"},
     *     message="Nie prawidłowe województwo")
     * @Assert\NotBlank(message="Województwo jest wymagane")
     */
    private $province;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Miejscowość jest wymagana")
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Animal", mappedBy="species")
     */
    private $animals;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\IsTrue(message="Wymagana jest zgoda na przetwarzanie danych")
     */
    private $termsAccepted;

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(?string $province): self
    {
        $this->province = $province;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

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
            $animal->setSpecies($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): self
    {
        if ($this->animals->contains($animal)) {
            $this->animals->removeElement($animal);
            // set the owning side to null (unless already changed)
            if ($animal->getSpecies() === $this) {
                $animal->setSpecies(null);
            }
        }

        return $this;
    }

    public function getTermsAccepted(): ?bool
    {
        return $this->termsAccepted;
    }

    public function setTermsAccepted(bool $termsAccepted): self
    {
        $this->termsAccepted = $termsAccepted;

        return $this;
    }
}
