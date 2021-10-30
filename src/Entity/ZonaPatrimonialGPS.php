<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="zonapatrimonialgps")
 * @ORM\Entity(repositoryClass="App\Repository\ZonaPatrimonialGPSRepository")
 */

class ZonaPatrimonialGPS
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="longitudpatrimonial", type="string",  nullable=true, length=255)
     * @Assert\Length(min=2, max=20, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $longitudpatrimonial;

    /**
     * @ORM\Column(name="latitudpatrimonial", type="string",  nullable=true, length=255)
     * @Assert\Length(min=2, max=20, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $latitudpatrimonial;

    /**
     * @ORM\ManyToOne(targetEntity = "SitioPatrimonial", inversedBy = "zonapatrimonialgps")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sitiopatrimonial;

    public function __toString()
    {
        return 'Latitud ' . $this->getLatitudpatrimonial() . ' - Longitud' . $this->getLongitudpatrimonial();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongitudpatrimonial(): ?string
    {
        return $this->longitudpatrimonial;
    }

    public function setLongitudpatrimonial(?string $longitudpatrimonial): self
    {
        $this->longitudpatrimonial = $longitudpatrimonial;

        return $this;
    }

    public function getLatitudpatrimonial(): ?string
    {
        return $this->latitudpatrimonial;
    }

    public function setLatitudpatrimonial(?string $latitudpatrimonial): self
    {
        $this->latitudpatrimonial = $latitudpatrimonial;

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
