<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="bibliografiaobjeto")
 * @ORM\Entity(repositoryClass="App\Repository\BibliografiaObjetoRepository")
 */

class BibliografiaObjeto
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
     * @ORM\ManyToOne(targetEntity="FichaObjetoPatrimonial", inversedBy="bibliografiaobjeto")
     * @ORM\JoinColumn(nullable=true, onDelete = "CASCADE")
     */
    private $fichaobjeto;

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

    public function getFichaobjeto(): ?FichaObjetoPatrimonial
    {
        return $this->fichaobjeto;
    }

    public function setFichaobjeto(?FichaObjetoPatrimonial $fichaobjeto): self
    {
        $this->fichaobjeto = $fichaobjeto;

        return $this;
    }
}
