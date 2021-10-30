<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="coordenadasgps")
 * @ORM\Entity(repositoryClass="App\Repository\CoordenadasGPSRepository")
 */

class CoordenadasGPS
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="longitud", type="string",  nullable=true, length=255)
     * @Assert\Length(min=2, max=20, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $longitud;

    /**
     * @ORM\Column(name="latitud", type="string",  nullable=true, length=255)
     * @Assert\Length(min=2, max=20, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $latitud;

    /**
     * @ORM\ManyToOne(targetEntity = "SitioPatrimonial", inversedBy = "coordenadasgps")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sitiopatrimonial;

    public function __toString()
    {
        return 'Latitud ' . $this->getLatitud() . ' - Longitud' . $this->getLongitud();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongitud(): ?string
    {
        return $this->longitud;
    }

    public function setLongitud(string $longitud): self
    {
        $this->longitud = $longitud;

        return $this;
    }

    public function getLatitud(): ?string
    {
        return $this->latitud;
    }

    public function setLatitud(string $latitud): self
    {
        $this->latitud = $latitud;

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
