<?php

namespace App\Entity;

use App\Repository\HistoriqueEvenementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoriqueEvenementRepository::class)
 */
class HistoriqueEvenement
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
    private $id_utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUtilisateur(): ?string
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(string $id_utilisateur): self
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }
}
