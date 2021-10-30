<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation\Auditable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProyectoRepository")
 * @UniqueEntity(fields={"codProyecto"}, message="Ya existe este Código de Proyecto.")
 * @Auditable()
 * @Vich\Uploadable
 */

class Proyecto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="cod_proyecto", type="string",  nullable=false, length=80, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío.")
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $codProyecto;

    /**
     * @var string
     * @ORM\Column(name="nombreproyecto", type="string",  nullable=false, length=80, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú ]*$/",
     *     message="Debe de contener solo letras"
     * )
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $nombre;

    /**
     * @Assert\Type("\DateTimeInterface")
     * @ORM\Column(name="fechainicio", type="datetime",  nullable=false)
     */
    private $fechaInicio;

    /**
     * @Assert\Type("\DateTimeInterface")
     * @ORM\Column(name="fechafin", type="datetime",  nullable=true)
     */
    private $fechaFin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $duracion;

    /**
     * @ORM\Column(type = "text", nullable=false)
     * @Assert\NotBlank(message="Este campo no debe estar vacío")
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $objGeneral;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $objEspecificos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $proyGeneral;

    /**
     * @Assert\File(
     *     maxSize = "2048k",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Por favor introducir un PDF valido."
     * )
     * @Vich\UploadableField(mapping="proyectogen_int", fileNameProperty="proyGeneral")
     * @var File
     */
    private $proyGeneralFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cartaAutorizacion;

    /**
     * @Assert\File(
     *     maxSize = "2048k",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Por favor introducir un PDF valido."
     * )
     * @Vich\UploadableField(mapping="cartaautorizacion_int", fileNameProperty="cartaAutorizacion")
     * @var File
     */
    private $cartaAutorizacionFile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Especialista", inversedBy="proyectos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $especialistaJefe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Estado", inversedBy="proyectos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $estado;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Especialista", inversedBy="proyectosParticipantes")
     */
    private $especialistasParticipantes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TipoProyecto", inversedBy="proyectos")
     */
    private $tipoProyecto;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity = "SitioPatrimonial", inversedBy = "proyecto")
     * @ORM\JoinColumn(name="sitiopatrimonial_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Sitio Patrimonial")
     */
    protected $sitiopatrimonial;

    public function __construct()
    {
        $this->especialistasParticipantes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodProyecto(): ?string
    {
        return $this->codProyecto;
    }

    public function setCodProyecto(string $codProyecto): self
    {
        $this->codProyecto = $codProyecto;

        return $this;
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

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(\DateTimeInterface $fechaInicio): self
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fechaFin;
    }

    public function setFechaFin(\DateTimeInterface $fechaFin): self
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    public function getDuracion(): ?string
    {
        return $this->duracion;
    }

    public function setDuracion(?string $duracion): self
    {
        $this->duracion = $duracion;

        return $this;
    }

    public function getObjGeneral(): ?string
    {
        return $this->objGeneral;
    }

    public function setObjGeneral(string $objGeneral): self
    {
        $this->objGeneral = $objGeneral;

        return $this;
    }

    public function getObjEspecificos(): ?string
    {
        return $this->objEspecificos;
    }

    public function setObjEspecificos(?string $objEspecificos): self
    {
        $this->objEspecificos = $objEspecificos;

        return $this;
    }

    public function getProyGeneral(): ?string
    {
        return $this->proyGeneral;
    }

    public function setProyGeneral(?string $proyGeneral): self
    {
        $this->proyGeneral = $proyGeneral;

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $proyGeneral
     */
    public function setProyGeneralFile(File $proyGeneral = null)
    {
        $this->proyGeneralFile = $proyGeneral;

        if ($proyGeneral) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getProyGeneralFile()
    {
        return $this->proyGeneralFile;
    }

    public function getCartaAutorizacion(): ?string
    {
        return $this->cartaAutorizacion;
    }

    public function setCartaAutorizacion(?string $cartaAutorizacion): self
    {
        $this->cartaAutorizacion = $cartaAutorizacion;

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $cartaAutorizacion
     */
    public function setCartaAutorizacionFile(File $cartaAutorizacion = null)
    {
        $this->cartaAutorizacionFile = $cartaAutorizacion;

        if ($cartaAutorizacion) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getCartaAutorizacionFile()
    {
        return $this->cartaAutorizacionFile;
    }

    public function getEspecialistaJefe(): ?Especialista
    {
        return $this->especialistaJefe;
    }

    public function setEspecialistaJefe(?Especialista $especialistaJefe): self
    {
        $this->especialistaJefe = $especialistaJefe;

        return $this;
    }

    public function getEstado(): ?Estado
    {
        return $this->estado;
    }

    public function setEstado(?Estado $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * @return Collection|Especialista[]
     */
    public function getEspecialistasParticipantes(): Collection
    {
        return $this->especialistasParticipantes;
    }

    public function addEspecialistasParticipante(Especialista $especialistasParticipante): self
    {
        if (!$this->especialistasParticipantes->contains($especialistasParticipante)) {
            $this->especialistasParticipantes[] = $especialistasParticipante;
        }

        return $this;
    }

    public function removeEspecialistasParticipante(Especialista $especialistasParticipante): self
    {
        if ($this->especialistasParticipantes->contains($especialistasParticipante)) {
            $this->especialistasParticipantes->removeElement($especialistasParticipante);
        }

        return $this;
    }

    public function getTipoProyecto(): ?TipoProyecto
    {
        return $this->tipoProyecto;
    }

    public function setTipoProyecto(?TipoProyecto $tipoProyecto): self
    {
        $this->tipoProyecto = $tipoProyecto;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
