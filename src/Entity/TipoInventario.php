<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation\Auditable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TipoInventarioRepository")
 * @UniqueEntity(fields={"nombre"}, message="Ya existe este Tipo de Inventario.")
 * @Auditable()
 */

class TipoInventario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nombretipoesp", type="string",  nullable=false, length=100, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú ]*$/",
     *     message="Debe de contener solo letras"
     * )
     * @Assert\Length(min=2, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Inventario", mappedBy="tipoinventario")
     */
    protected $inventario;

    public function __construct()
    {
        $this->inventario = new ArrayCollection();
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
     * @return Collection|Inventario[]
     */
    public function getInventario(): Collection
    {
        return $this->inventario;
    }

    public function addInventario(Inventario $inventario): self
    {
        if (!$this->inventario->contains($inventario)) {
            $this->inventario[] = $inventario;
            $inventario->setTipoinventario($this);
        }

        return $this;
    }

    public function removeInventario(Inventario $inventario): self
    {
        if ($this->inventario->contains($inventario)) {
            $this->inventario->removeElement($inventario);
            // set the owning side to null (unless already changed)
            if ($inventario->getTipoinventario() === $this) {
                $inventario->setTipoinventario(null);
            }
        }

        return $this;
    }

}
