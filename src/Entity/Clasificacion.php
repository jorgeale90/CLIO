<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation\Auditable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClasificacionRepository")
 * @UniqueEntity(fields={"nombre"}, message="Ya existe esta Clasificación.")
 * @Auditable()
 */

class Clasificacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nombreclasificacion", type="string",  nullable=false, length=80, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú ]*$/",
     *     message="Debe de contener solo letras"
     * )
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="FichaObjetoPatrimonial", mappedBy="clasificacion")
     */
    protected $fichaobjeto;

    public function __construct()
    {
        $this->fichaobjeto = new ArrayCollection();
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
     * @return Collection|FichaObjetoPatrimonial[]
     */
    public function getFichaobjeto(): Collection
    {
        return $this->fichaobjeto;
    }

    public function addFichaobjeto(FichaObjetoPatrimonial $fichaobjeto): self
    {
        if (!$this->fichaobjeto->contains($fichaobjeto)) {
            $this->fichaobjeto[] = $fichaobjeto;
            $fichaobjeto->setClasificacion($this);
        }

        return $this;
    }

    public function removeFichaobjeto(FichaObjetoPatrimonial $fichaobjeto): self
    {
        if ($this->fichaobjeto->contains($fichaobjeto)) {
            $this->fichaobjeto->removeElement($fichaobjeto);
            // set the owning side to null (unless already changed)
            if ($fichaobjeto->getClasificacion() === $this) {
                $fichaobjeto->setClasificacion(null);
            }
        }

        return $this;
    }
}
