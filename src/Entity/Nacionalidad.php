<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation\Auditable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NacionalidadRepository")
 * @UniqueEntity(fields={"nombre"}, message="Ya existe esta Nacionalidad.")
 * @Auditable()
 */

class Nacionalidad
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nombrenacionalidad", type="string",  nullable=false, length=80, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú ]*$/",
     *     message="Debe de contener solo letras"
     * )
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Especialista", mappedBy="nacionalidad")
     */
    private $especialistas;

    public function __construct()
    {
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
            $especialista->setNacionalidad($this);
        }

        return $this;
    }

    public function removeEspecialista(Especialista $especialista): self
    {
        if ($this->especialistas->contains($especialista)) {
            $this->especialistas->removeElement($especialista);
            // set the owning side to null (unless already changed)
            if ($especialista->getNacionalidad() === $this) {
                $especialista->setNacionalidad(null);
            }
        }

        return $this;
    }

}
