<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="ordeninventario")
 * @ORM\Entity(repositoryClass="App\Repository\OrdenInventarioRepository")
 */

class OrdenInventario
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
     * @ORM\ManyToOne(targetEntity="Inventario", inversedBy="ordeninventario")
     * @ORM\JoinColumn(nullable=true)
     */
    private $inventario;

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

    public function getInventario(): ?Inventario
    {
        return $this->inventario;
    }

    public function setInventario(?Inventario $inventario): self
    {
        $this->inventario = $inventario;

        return $this;
    }
}
