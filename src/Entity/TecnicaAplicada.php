<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation\Auditable;

/**
 * @ORM\Table(name="tecnica_aplicada")
 * @ORM\Entity(repositoryClass="App\Repository\TecnicaAplicadaRepository")
 * @UniqueEntity(fields={"nombre"}, message="Ya existe esta Tecnica Aplicada.")
 * @Auditable()
 */

class TecnicaAplicada
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nombretecnicaapli", type="string",  nullable=false, length=100, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú ]*$/",
     *     message="Debe de contener solo letras"
     * )
     * @Assert\Length(min=2, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="IntervencionConservacion", mappedBy="tecnicaaplicada")
     */
    protected $intervencionconservacion;

    public function __construct()
    {
        $this->intervencionconservacion = new ArrayCollection();
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
     * @return Collection|IntervencionConservacion[]
     */
    public function getIntervencionconservacion(): Collection
    {
        return $this->intervencionconservacion;
    }

    public function addIntervencionconservacion(IntervencionConservacion $intervencionconservacion): self
    {
        if (!$this->intervencionconservacion->contains($intervencionconservacion)) {
            $this->intervencionconservacion[] = $intervencionconservacion;
            $intervencionconservacion->setTecnicaaplicada($this);
        }

        return $this;
    }

    public function removeIntervencionconservacion(IntervencionConservacion $intervencionconservacion): self
    {
        if ($this->intervencionconservacion->contains($intervencionconservacion)) {
            $this->intervencionconservacion->removeElement($intervencionconservacion);
            // set the owning side to null (unless already changed)
            if ($intervencionconservacion->getTecnicaaplicada() === $this) {
                $intervencionconservacion->setTecnicaaplicada(null);
            }
        }

        return $this;
    }
}
