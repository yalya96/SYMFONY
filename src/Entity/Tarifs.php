<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TarifsRepository")
 */
class Tarifs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="bigint")
     */
    private $BorneInferieure;

    /**
     * @ORM\Column(type="bigint")
     */
    private $BorneSuperieure;

    /**
     * @ORM\Column(type="bigint")
     */
    private $Valeur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorneInferieure(): ?string
    {
        return $this->BorneInferieure;
    }

    public function setBorneInferieure(string $BorneInferieure): self
    {
        $this->BorneInferieure = $BorneInferieure;

        return $this;
    }

    public function getBorneSuperieure(): ?string
    {
        return $this->BorneSuperieure;
    }

    public function setBorneSuperieure(string $BorneSuperieure): self
    {
        $this->BorneSuperieure = $BorneSuperieure;

        return $this;
    }

    public function getValeur(): ?string
    {
        return $this->Valeur;
    }

    public function setValeur(string $Valeur): self
    {
        $this->Valeur = $Valeur;

        return $this;
    }
}
