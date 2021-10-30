<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation\Auditable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ZonaCosteraRepository")
 * @UniqueEntity(fields={"nombre"}, message="Ya existe esta Zona Costera.")
 * @Auditable()
 */

class ZonaCostera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nombrezonacost", type="string",  nullable=false, length=100, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú0-9 ]*$/",
     *     message="Debe de contener solo letras"
     * )
     * @Assert\Length(min=2, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="SitioPatrimonial", mappedBy="zonacostera")
     */
    protected $sitiopatrimonial;

    public function __construct()
    {
        $this->sitiopatrimonial = new ArrayCollection();
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
            $sitiopatrimonial->setZonacostera($this);
        }

        return $this;
    }

    public function removeSitiopatrimonial(SitioPatrimonial $sitiopatrimonial): self
    {
        if ($this->sitiopatrimonial->contains($sitiopatrimonial)) {
            $this->sitiopatrimonial->removeElement($sitiopatrimonial);
            // set the owning side to null (unless already changed)
            if ($sitiopatrimonial->getZonacostera() === $this) {
                $sitiopatrimonial->setZonacostera(null);
            }
        }

        return $this;
    }
}
