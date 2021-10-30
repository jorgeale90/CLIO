<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="zonainsertidumbregps")
 * @ORM\Entity(repositoryClass="App\Repository\ZonaInsertidumbreGPSRepository")
 */
class ZonaInsertidumbreGPS
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="longitudinsert", type="string",  nullable=true, length=255)
     * @Assert\Length(min=2, max=20, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $longitudinsert;

    /**
     * @ORM\Column(name="latitudinsert", type="string",  nullable=true, length=255)
     * @Assert\Length(min=2, max=20, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $latitudinsert;

    /**
     * @ORM\ManyToOne(targetEntity = "SitioPatrimonial", inversedBy = "zonainsertidumbregps")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sitiopatrimonial;

    public function __toString()
    {
        return 'Latitud ' . $this->getLatitudinsert() . ' - Longitud' . $this->getLongitudinsert();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongitudinsert(): ?string
    {
        return $this->longitudinsert;
    }

    public function setLongitudinsert(?string $longitudinsert): self
    {
        $this->longitudinsert = $longitudinsert;

        return $this;
    }

    public function getLatitudinsert(): ?string
    {
        return $this->latitudinsert;
    }

    public function setLatitudinsert(?string $latitudinsert): self
    {
        $this->latitudinsert = $latitudinsert;

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
