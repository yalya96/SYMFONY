<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PrestataireRepository")
 */
class Prestataire
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
    private $NomEntreprise;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Ninea;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $TelephoneEntreprise;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $AdresseEntreprise;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Statut;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="prestataires")
     */
    private $AdminCreateur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="Prest")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->NomEntreprise;
    }

    public function setNomEntreprise(string $NomEntreprise): self
    {
        $this->NomEntreprise = $NomEntreprise;

        return $this;
    }

    public function getNinea(): ?string
    {
        return $this->Ninea;
    }

    public function setNinea(string $Ninea): self
    {
        $this->Ninea = $Ninea;

        return $this;
    }

    public function getTelephoneEntreprise(): ?string
    {
        return $this->TelephoneEntreprise;
    }

    public function setTelephoneEntreprise(string $TelephoneEntreprise): self
    {
        $this->TelephoneEntreprise = $TelephoneEntreprise;

        return $this;
    }

    public function getAdresseEntreprise(): ?string
    {
        return $this->AdresseEntreprise;
    }

    public function setAdresseEntreprise(string $AdresseEntreprise): self
    {
        $this->AdresseEntreprise = $AdresseEntreprise;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->Statut;
    }

    public function setStatut(string $Statut): self
    {
        $this->Statut = $Statut;

        return $this;
    }

    public function getAdminCreateur(): ?User
    {
        return $this->AdminCreateur;
    }

    public function setAdminCreateur(?User $AdminCreateur): self
    {
        $this->AdminCreateur = $AdminCreateur;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setPrest($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getPrest() === $this) {
                $user->setPrest(null);
            }
        }

        return $this;
    }
}
