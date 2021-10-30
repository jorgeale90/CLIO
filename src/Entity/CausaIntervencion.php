<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation\Auditable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CausaIntervencionRepository")
 * @UniqueEntity(fields={"nombre"}, message="Ya existe esta Causa de Intervención.")
 * @Auditable()
 */

class CausaIntervencion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nombrecausaint", type="string",  nullable=false, length=80, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú ]*$/",
     *     message="Debe de contener solo letras"
     * )
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Intervencion", mappedBy="causaintervencion")
     */
    private $intervencion;

    public function __construct()
    {
        $this->intervencion = new ArrayCollection();
    }

    public function __toString() {

        return $this->getNombre();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection|Intervencion[]
     */
    public function getIntervencion(): Collection
    {
        return $this->intervencion;
    }

    public function addIntervencion(Intervencion $intervencion): self
    {
        if (!$this->intervencion->contains($intervencion)) {
            $this->intervencion[] = $intervencion;
            $intervencion->setCausaintervencion($this);
        }

        return $this;
    }

    public function removeIntervencion(Intervencion $intervencion): self
    {
        if ($this->intervencion->contains($intervencion)) {
            $this->intervencion->removeElement($intervencion);
            // set the owning side to null (unless already changed)
            if ($intervencion->getCausaintervencion() === $this) {
                $intervencion->setCausaintervencion(null);
            }
        }

        return $this;
    }

}
