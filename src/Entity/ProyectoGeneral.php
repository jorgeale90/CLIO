<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="proyectogeneralinter")
 * @ORM\Entity(repositoryClass="App\Repository\ProyectoGeneralRepository")
 */

class ProyectoGeneral
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\ManyToOne(targetEntity="IntervencionConservacion", inversedBy="proyectogeneral")
     * @ORM\JoinColumn(nullable=true, onDelete = "CASCADE")
     */
    private $intervencionconservacion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getIntervencionconservacion(): ?IntervencionConservacion
    {
        return $this->intervencionconservacion;
    }

    public function setIntervencionconservacion(?IntervencionConservacion $intervencionconservacion): self
    {
        $this->intervencionconservacion = $intervencionconservacion;

        return $this;
    }
}
