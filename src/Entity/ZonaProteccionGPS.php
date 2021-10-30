<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="zonaprotecciongps")
 * @ORM\Entity(repositoryClass="App\Repository\ZonaProteccionGPSRepository")
 */

class ZonaProteccionGPS
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="longitudproteccion", type="string",  nullable=true, length=255)
     * @Assert\Length(min=2, max=20, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $longitudproteccion;

    /**
     * @ORM\Column(name="latitudproteccion", type="string",  nullable=true, length=255)
     * @Assert\Length(min=2, max=20, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $latitudproteccion;

    /**
     * @ORM\ManyToOne(targetEntity = "SitioPatrimonial", inversedBy = "zonaprotecciongps")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sitiopatrimonial;

    public function __toString()
    {
        return 'Latitud ' . $this->getLatitudproteccion() . ' - Longitud' . $this->getLongitudproteccion();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongitudproteccion(): ?string
    {
        return $this->longitudproteccion;
    }

    public function setLongitudproteccion(?string $longitudproteccion): self
    {
        $this->longitudproteccion = $longitudproteccion;

        return $this;
    }

    public function getLatitudproteccion(): ?string
    {
        return $this->latitudproteccion;
    }

    public function setLatitudproteccion(?string $latitudproteccion): self
    {
        $this->latitudproteccion = $latitudproteccion;

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
