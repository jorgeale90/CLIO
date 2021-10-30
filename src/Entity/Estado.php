<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation\Auditable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EstadoRepository")
 * @UniqueEntity(fields={"nombre"}, message="Ya existe este Estado.")
 * @Auditable()
 */

class Estado
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nombreestado", type="string",  nullable=false, length=80, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú ]*$/",
     *     message="Debe de contener solo letras"
     * )
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Intervencion", mappedBy="estado")
     */
    private $intervencion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Proyecto", mappedBy="estado")
     */
    private $proyectos;

    public function __construct()
    {
        $this->intervencion = new ArrayCollection();
        $this->proyectos = new ArrayCollection();
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
     * @return Collection|Proyecto[]
     */
    public function getProyectos(): Collection
    {
        return $this->proyectos;
    }

    public function addProyecto(Proyecto $proyecto): self
    {
        if (!$this->proyectos->contains($proyecto)) {
            $this->proyectos[] = $proyecto;
            $proyecto->setEstado($this);
        }

        return $this;
    }

    public function removeProyecto(Proyecto $proyecto): self
    {
        if ($this->proyectos->contains($proyecto)) {
            $this->proyectos->removeElement($proyecto);
            // set the owning side to null (unless already changed)
            if ($proyecto->getEstado() === $this) {
                $proyecto->setEstado(null);
            }
        }

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
            $intervencion->setEstado($this);
        }

        return $this;
    }

    public function removeIntervencion(Intervencion $intervencion): self
    {
        if ($this->intervencion->contains($intervencion)) {
            $this->intervencion->removeElement($intervencion);
            // set the owning side to null (unless already changed)
            if ($intervencion->getEstado() === $this) {
                $intervencion->setEstado(null);
            }
        }

        return $this;
    }

}
