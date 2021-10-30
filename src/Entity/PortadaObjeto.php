<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="portadaobjeto")
 * @ORM\Entity(repositoryClass="App\Repository\PortadaObjetoRepository")
 */

class PortadaObjeto
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
     * @ORM\ManyToOne(targetEntity="FichaObjetoPatrimonial", inversedBy="portadaobjeto")
     * @ORM\JoinColumn(nullable=true)
     */
    private $fichaobjetopat;

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

    public function getFichaobjetopat(): ?FichaObjetoPatrimonial
    {
        return $this->fichaobjetopat;
    }

    public function setFichaobjetopat(?FichaObjetoPatrimonial $fichaobjetopat): self
    {
        $this->fichaobjetopat = $fichaobjetopat;

        return $this;
    }
}
