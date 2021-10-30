<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation\Auditable;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IntervencionRepository")
 * @UniqueEntity(fields={"cod_intervencion"}, message="Ya existe este Código de Intervención.")
 * @Auditable()
 * @Vich\Uploadable
 */

class Intervencion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="cod_intervencion", type="string",  nullable=false, length=80, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú0-9 ]*$/",
     *     message="Debe de contener solo letras o números"
     * )
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $cod_intervencion;

    /**
     * @Assert\Type("\DateTimeInterface")
     * @ORM\Column(name="fechainicio", type="datetime",  nullable=false)
     */
    private $fechainicio;

    /**
     * @Assert\Type("\DateTimeInterface")
     * @ORM\Column(name="fechafin", type="datetime",  nullable=true)
     */
    private $fechafin;

    /**
     * @var string
     * @ORM\Column(name="duracion", type="string",  nullable=true, length=80)
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú0-9 ]*$/",
     *     message="Debe de contener solo números"
     * )
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $duracion;

    /**
     * @ORM\Column(type = "text", nullable=false)
     * @Assert\NotBlank(message="Este campo no debe estar vacío")
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $objetivo_general;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $objetivo_especificos;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=1000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $proyectogeneral;

    /**
     * @Assert\File(
     *     maxSize = "2048k",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Por favor introducir un PDF valido."
     * )
     * @Vich\UploadableField(mapping="proyectogen_int", fileNameProperty="proyectogeneral")
     * @var File
     */
    private $proyectogeneralFile;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="created_at", nullable=true)
     */
    private $createdAt = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $cartaautorizacion;

    /**
     * @Assert\File(
     *     maxSize = "2048k",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Por favor introducir un PDF valido."
     * )
     * @Vich\UploadableField(mapping="cartaautorizacion_int", fileNameProperty="cartaautorizacion")
     * @var File
     */
    private $cartaautorizacionFile;

    /**
     * @ORM\ManyToOne(targetEntity = "SitioPatrimonial", inversedBy = "intervencion")
     * @ORM\JoinColumn(name="sitiopatrimonial_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Sitio Patrimonial")
     */
    protected $sitiopatrimonial;

    /**
     * @ORM\ManyToOne(targetEntity = "Especialista", inversedBy = "intervencionjefe")
     * @ORM\JoinColumn(name="especialistajefe_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Especialista Jefe (Responsable del Proyecto)")
     */
    protected $especialistajefe;

    /**
     * @ORM\ManyToMany(targetEntity="Especialista", inversedBy="intervencionpart", cascade={"remove","persist"})
     * @ORM\JoinTable(
     *     name="intervencion_especialistapart",
     *     joinColumns={
     *          @ORM\JoinColumn(name="intervencion_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="especialistapart_id", referencedColumnName="id")
     *     }
     * )
     * @Assert\Count(min=1, max=20, minMessage="Debe seleccionar al menos {{ limit }} Especialista", maxMessage="Debe  seleccionar a lo sumo {{ limit }} Especialistas")*
     */
    protected $especialistapart;

    /**
     * @ORM\ManyToOne(targetEntity = "Estado", inversedBy = "intervencion")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Estado")
     */
    protected $estado;

    /**
     * @ORM\ManyToOne(targetEntity = "Organismo", inversedBy = "intervencion")
     * @ORM\JoinColumn(name="organismo_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Organismo")
     */
    protected $organismo;

    /**
     * @ORM\ManyToOne(targetEntity = "CausaIntervencion", inversedBy = "intervencion")
     * @ORM\JoinColumn(name="causaintervencion_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Causa de la Intervención")
     */
    protected $causaintervencion;

    /**
     * @ORM\ManyToOne(targetEntity = "TipoIntervencion", inversedBy = "intervencion")
     * @ORM\JoinColumn(name="tipointervencion_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Tipo de Intervención")
     */
    protected $tipointervencion;

    public function __construct()
    {
        $this->especialistapart = new ArrayCollection();
    }

    public function __toString() {

        return $this->getCodIntervencion();

    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $proyectogeneral
     */
    public function setProyectogeneralFile(File $proyectogeneral = null)
    {
        $this->proyectogeneralFile = $proyectogeneral;

        if ($proyectogeneral) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getProyectogeneralFile()
    {
        return $this->proyectogeneralFile;
    }

    public function getProyectogeneral(): ?string
    {
        return $this->proyectogeneral;
    }

    public function setProyectogeneral(?string $proyectogeneral): self
    {
        $this->proyectogeneral = $proyectogeneral;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $cartaautorizacion
     */
    public function setCartaautorizacionFile(File $cartaautorizacion = null)
    {
        $this->cartaautorizacionFile = $cartaautorizacion;

        if ($cartaautorizacion) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getCartaautorizacionFile()
    {
        return $this->cartaautorizacionFile;
    }

    public function getCartaautorizacion(): ?string
    {
        return $this->cartaautorizacion;
    }

    public function setCartaautorizacion(?string $cartaautorizacion): self
    {
        $this->cartaautorizacion = $cartaautorizacion;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodIntervencion(): ?string
    {
        return $this->cod_intervencion;
    }

    public function setCodIntervencion(string $cod_intervencion): self
    {
        $this->cod_intervencion = $cod_intervencion;

        return $this;
    }

    public function getFechainicio(): ?\DateTimeInterface
    {
        return $this->fechainicio;
    }

    public function setFechainicio(\DateTimeInterface $fechainicio): self
    {
        $this->fechainicio = $fechainicio;

        return $this;
    }

    public function getFechafin(): ?\DateTimeInterface
    {
        return $this->fechafin;
    }

    public function setFechafin(?\DateTimeInterface $fechafin): self
    {
        $this->fechafin = $fechafin;

        return $this;
    }

    public function getDuracion(): ?string
    {
        return $this->duracion;
    }

    public function setDuracion(string $duracion): self
    {
        $this->duracion = $duracion;

        return $this;
    }

    public function getObjetivoGeneral(): ?string
    {
        return $this->objetivo_general;
    }

    public function setObjetivoGeneral(string $objetivo_general): self
    {
        $this->objetivo_general = $objetivo_general;

        return $this;
    }

    public function getObjetivoEspecificos(): ?string
    {
        return $this->objetivo_especificos;
    }

    public function setObjetivoEspecificos(string $objetivo_especificos): self
    {
        $this->objetivo_especificos = $objetivo_especificos;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

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

    public function getEspecialistajefe(): ?Especialista
    {
        return $this->especialistajefe;
    }

    public function setEspecialistajefe(?Especialista $especialistajefe): self
    {
        $this->especialistajefe = $especialistajefe;

        return $this;
    }

    /**
     * @return Collection|Especialista[]
     */
    public function getEspecialistapart(): Collection
    {
        return $this->especialistapart;
    }

    public function addEspecialistapart(Especialista $especialistapart): self
    {
        if (!$this->especialistapart->contains($especialistapart)) {
            $this->especialistapart[] = $especialistapart;
        }

        return $this;
    }

    public function removeEspecialistapart(Especialista $especialistapart): self
    {
        if ($this->especialistapart->contains($especialistapart)) {
            $this->especialistapart->removeElement($especialistapart);
        }

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

    public function getOrganismo(): ?Organismo
    {
        return $this->organismo;
    }

    public function setOrganismo(?Organismo $organismo): self
    {
        $this->organismo = $organismo;

        return $this;
    }

    public function getCausaintervencion(): ?CausaIntervencion
    {
        return $this->causaintervencion;
    }

    public function setCausaintervencion(?CausaIntervencion $causaintervencion): self
    {
        $this->causaintervencion = $causaintervencion;

        return $this;
    }

    public function getTipointervencion(): ?TipoIntervencion
    {
        return $this->tipointervencion;
    }

    public function setTipointervencion(?TipoIntervencion $tipointervencion): self
    {
        $this->tipointervencion = $tipointervencion;

        return $this;
    }
}
