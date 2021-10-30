<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation\Auditable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaisRepository")
 * @UniqueEntity(fields={"nombre"}, message="Ya existe este País.")
 * @Auditable()
 */

class Pais
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nombrepais", type="string",  nullable=false, length=80, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú ]*$/",
     *     message="Debe de contener solo letras"
     * )
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Provincia", mappedBy="pais")
     */
    protected $provincia;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Especialista", mappedBy="pais")
     */
    private $especialistas;

    /**
     * @ORM\OneToMany(targetEntity="SitioPatrimonial", mappedBy="pais")
     */
    protected $sitiopatrimonial;

    /**
     * @ORM\OneToMany(targetEntity="FichaObjetoPatrimonial", mappedBy="pais")
     */
    protected $fichaobjeto;

    public function __construct()
    {
        $this->provincia = new ArrayCollection();
        $this->especialistas = new ArrayCollection();
        $this->sitiopatrimonial = new ArrayCollection();
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
     * @return Collection|Provincia[]
     */
    public function getProvincia(): Collection
    {
        return $this->provincia;
    }

    public function addProvincium(Provincia $provincium): self
    {
        if (!$this->provincia->contains($provincium)) {
            $this->provincia[] = $provincium;
            $provincium->setPais($this);
        }

        return $this;
    }

    public function removeProvincium(Provincia $provincium): self
    {
        if ($this->provincia->contains($provincium)) {
            $this->provincia->removeElement($provincium);
            // set the owning side to null (unless already changed)
            if ($provincium->getPais() === $this) {
                $provincium->setPais(null);
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
            $especialista->setPais($this);
        }

        return $this;
    }

    public function removeEspecialista(Especialista $especialista): self
    {
        if ($this->especialistas->contains($especialista)) {
            $this->especialistas->removeElement($especialista);
            // set the owning side to null (unless already changed)
            if ($especialista->getPais() === $this) {
                $especialista->setPais(null);
            }
        }

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
            $sitiopatrimonial->setPais($this);
        }

        return $this;
    }

    public function removeSitiopatrimonial(SitioPatrimonial $sitiopatrimonial): self
    {
        if ($this->sitiopatrimonial->contains($sitiopatrimonial)) {
            $this->sitiopatrimonial->removeElement($sitiopatrimonial);
            // set the owning side to null (unless already changed)
            if ($sitiopatrimonial->getPais() === $this) {
                $sitiopatrimonial->setPais(null);
            }
        }

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
            $fichaobjeto->setPais($this);
        }

        return $this;
    }

    public function removeFichaobjeto(FichaObjetoPatrimonial $fichaobjeto): self
    {
        if ($this->fichaobjeto->contains($fichaobjeto)) {
            $this->fichaobjeto->removeElement($fichaobjeto);
            // set the owning side to null (unless already changed)
            if ($fichaobjeto->getPais() === $this) {
                $fichaobjeto->setPais(null);
            }
        }

        return $this;
    }

}
