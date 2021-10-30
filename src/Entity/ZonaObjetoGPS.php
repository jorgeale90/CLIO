<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="zonaobjetogps")
 * @ORM\Entity(repositoryClass="App\Repository\ZonaObjetoGPSRepository")
 */

class ZonaObjetoGPS
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="longitudobjeto", type="string",  nullable=true, length=255)
     * @Assert\Length(min=2, max=20, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $longitudobjeto;

    /**
     * @ORM\Column(name="latitudobjeto", type="string",  nullable=true, length=255)
     * @Assert\Length(min=2, max=20, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $latitudobjeto;

    /**
     * @ORM\ManyToOne(targetEntity = "SitioPatrimonial", inversedBy = "zonaobjetogps")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sitiopatrimonial;

    public function __toString()
    {
        return 'Latitud ' . $this->getLatitudobjeto() . ' - Longitud' . $this->getLongitudobjeto();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongitudobjeto(): ?string
    {
        return $this->longitudobjeto;
    }

    public function setLongitudobjeto(?string $longitudobjeto): self
    {
        $this->longitudobjeto = $longitudobjeto;

        return $this;
    }

    public function getLatitudobjeto(): ?string
    {
        return $this->latitudobjeto;
    }

    public function setLatitudobjeto(?string $latitudobjeto): self
    {
        $this->latitudobjeto = $latitudobjeto;

        return $this;
    }

    public function getSitiopatrimonial(): ?SitioPatrimonial
    {
        return $this->sitiopatrimonial;
    }

    public function setSitiopatrimonial(?SitioPatrimonial $sitiopatrimonial): self
    {
        $this->sitiopatrimonial = $sitiopatrimonial;

        return $this;
    }
}
