<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation\Auditable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MunicipioRepository")
 * @UniqueEntity(fields={"nombre"}, message="Ya existe este Municipio.")
 * @Auditable()
 */

class Municipio
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nombremunicipio", type="string",  nullable=false, length=80, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú ]*$/",
     *     message="Debe de contener solo letras"
     * )
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity = "Provincia", inversedBy = "municipio")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Provincia")
     */
    protected $provincia;

    /**
     * @ORM\OneToMany(targetEntity="SitioPatrimonial", mappedBy="municipio")
     */
    protected $sitiopatrimonial;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Especialista", mappedBy="town")
     */
    private $especialistas;

    public function __construct()
    {
        $this->sitiopatrimonial = new ArrayCollection();
        $this->especialistas = new ArrayCollection();
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

    public function getProvincia(): ?Provincia
    {
        return $this->provincia;
    }

    public function setProvincia(?Provincia $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * @return Collection|SitioPatrimonial[]
     */
    public function getSitiopatrimonial(): Collection
    {
        return $this->sitiopatrimonial;
    }

    public function addSitiopatrimonial(SitioPatrimonial $sitiopatrimonial): self
    {
        if (!$this->sitiopatrimonial->contains($sitiopatrimonial)) {
            $this->sitiopatrimonial[] = $sitiopatrimonial;
            $sitiopatrimonial->setMunicipio($this);
        }

        return $this;
    }

    public function removeSitiopatrimonial(SitioPatrimonial $sitiopatrimonial): self
    {
        if ($this->sitiopatrimonial->contains($sitiopatrimonial)) {
            $this->sitiopatrimonial->removeElement($sitiopatrimonial);
            // set the owning side to null (unless already changed)
            if ($sitiopatrimonial->getMunicipio() === $this) {
                $sitiopatrimonial->setMunicipio(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Especialista[]
     */
    public function getEspecialistas(): Collection
    {
        return $this->especialistas;
    }

    public function addEspecialista(Especialista $especialista): self
    {
        if (!$this->especialistas->contains($especialista)) {
            $this->especialistas[] = $especialista;
            $especialista->setTown($this);
        }

        return $this;
    }

    public function removeEspecialista(Especialista $especialista): self
    {
        if ($this->especialistas->contains($especialista)) {
            $this->especialistas->removeElement($especialista);
            // set the owning side to null (unless already changed)
            if ($especialista->getTown() === $this) {
                $especialista->setTown(null);
            }
        }

        return $this;
    }
}
