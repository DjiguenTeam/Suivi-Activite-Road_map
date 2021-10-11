<?php

namespace App\Entity;

use App\Entity\Activite;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PointDeCoordinationRepository;

/**
 * @ORM\Entity(repositoryClass=PointDeCoordinationRepository::class)
 */
class PointDeCoordination
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $structure_impactee;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\ManyToOne(targetEntity=Activite::class, inversedBy="pointDeCoordination")
     */
    private $activite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getStructureImpactee(): ?string
    {
        return $this->structure_impactee;
    }

    public function setStructureImpactee(string $structure_impactee): self
    {
        $this->structure_impactee = $structure_impactee;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getActivite(): ?Activite
    {
        return $this->activite;
    }

    public function setActivite(?Activite $activite): self
    {
        $this->activite = $activite;

        return $this;
    }
}
