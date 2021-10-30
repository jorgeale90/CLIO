<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation\Auditable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IntervencionConservacionRepository")
 * @UniqueEntity(fields={"cod_intervencion"}, message="Ya existe esta Intervención de Conservación.")
 * @Auditable()
 */

class IntervencionConservacion
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
     *     message="Debe de contener solo letras o números."
     * )
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $cod_intervencion;

    /**
     * @Assert\Type("\DateTimeInterface")
     * @ORM\Column(name="fechainicio", type="datetime",  nullable=true)
     */
    private $fechainicio;

    /**
     * @Assert\Type("\DateTimeInterface")
     * @ORM\Column(name="fechafin", type="datetime",  nullable=true)
     */
    private $fechafin;

    /**
     * @var string
     * @ORM\Column(name="duracion", type="string",  nullable=true, length=100)
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú0-9 ]*$/",
     *     message="Debe de contener solo letras o números."
     * )
     * @Assert\Length(min=1, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $duracion;

    /**
     * @ORM\Column(type = "text", nullable=true)
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
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="ProyectoGeneral", mappedBy="intervencionconservacion", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $proyectogeneral;

    /**
     * @ORM\OneToMany(targetEntity="CartaAutorizacion", mappedBy="intervencionconservacion", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $cartaautorizacion;

    /**
     * @ORM\ManyToOne(targetEntity = "SitioPatrimonial", inversedBy = "intervencionconservacion")
     * @ORM\JoinColumn(name="sitiopatrimonial_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Sitio Patrimonial")
     */
    protected $sitiopatrimonial;

    /**
     * @ORM\ManyToOne(targetEntity = "FichaObjetoPatrimonial", inversedBy = "intervencionconservacion")
     * @ORM\JoinColumn(name="fichaobjeto_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Objeto Patrimonial")
     */
    protected $fichaobjeto;

    /**
     * @ORM\ManyToOne(targetEntity = "Especialista", inversedBy = "intervencionconservacionjefe")
     * @ORM\JoinColumn(name="especialistajefe_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Especialista Jefe")
     */
    protected $especialista_jefe;

    /**
     * @ORM\ManyToMany(targetEntity="Especialista", inversedBy="intervencionconservpart", cascade={"remove","persist"})
     * @ORM\JoinTable(
     *     name="intervencionconserv_especialistapart",
     *     joinColumns={
     *          @ORM\JoinColumn(name="intervencionconservacion_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="especialistapart_id", referencedColumnName="id")
     *     }
     * )
     * @Assert\Count(min=1, max=20, minMessage="Debe seleccionar al menos {{ limit }} Especialista", maxMessage="Debe  seleccionar a lo sumo {{ limit }} Especialistas")*
     */
    protected $especialistapart;

    /**
     * @ORM\ManyToOne(targetEntity = "TipoIntervencionObjeto", inversedBy = "intervencionconservacion")
     * @ORM\JoinColumn(name="tipointervencionobj_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Tipo de Intervención")
     */
    protected $tipointervencionobj;

    /**
     * @ORM\ManyToOne(targetEntity = "CausaIntervencionObjeto", inversedBy = "intervencionconservacion")
     * @ORM\JoinColumn(name="causaintervencionobj_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Tipo de Intervención")
     */
    protected $causaintervencionobj;

    /**
     * @ORM\ManyToOne(targetEntity = "TratamientoInsitu", inversedBy = "intervencionconservacion")
     * @ORM\JoinColumn(name="tratamientoinsitu_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Tratamiento Insitu.")
     */
    protected $tratamientoinsitu;

    /**
     * @ORM\ManyToOne(targetEntity = "TratamientoLaboratorio", inversedBy = "intervencionconservacion")
     * @ORM\JoinColumn(name="tratamientolaboratorio_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Tratamiento Insitu.")
     */
    protected $tratamientolaboratorio;

    /**
     * @ORM\ManyToOne(targetEntity = "TecnicaAplicada", inversedBy = "intervencionconservacion")
     * @ORM\JoinColumn(name="tecnicaaplicada_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Tratamiento Insitu.")
     */
    protected $tecnicaaplicada;

    public function __construct()
    {
        $this->proyectogeneral = new ArrayCollection();
        $this->cartaautorizacion = new ArrayCollection();
        $this->especialistapart = new ArrayCollection();
    }

    public function __toString() {

        return $this->getCodIntervencion();

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

    public function setFechainicio(?\DateTimeInterface $fechainicio): self
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

    public function setDuracion(?string $duracion): self
    {
        $this->duracion = $duracion;

        return $this;
    }

    public function getObjetivoGeneral(): ?string
    {
        return $this->objetivo_general;
    }

    public function setObjetivoGeneral(?string $objetivo_general): self
    {
        $this->objetivo_general = $objetivo_general;

        return $this;
    }

    public function getObjetivoEspecificos(): ?string
    {
        return $this->objetivo_especificos;
    }

    public function setObjetivoEspecificos(?string $objetivo_especificos): self
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

    /**
     * @return Collection|ProyectoGeneral[]
     */
    public function getProyectogeneral(): Collection
    {
        return $this->proyectogeneral;
    }

    public function addProyectogeneral(ProyectoGeneral $proyectogeneral): self
    {
        if (!$this->proyectogeneral->contains($proyectogeneral)) {
            $this->proyectogeneral[] = $proyectogeneral;
            $proyectogeneral->setIntervencionconservacion($this);
        }

        return $this;
    }

    public function removeProyectogeneral(ProyectoGeneral $proyectogeneral): self
    {
        if ($this->proyectogeneral->contains($proyectogeneral)) {
            $this->proyectogeneral->removeElement($proyectogeneral);
            // set the owning side to null (unless already changed)
            if ($proyectogeneral->getIntervencionconservacion() === $this) {
                $proyectogeneral->setIntervencionconservacion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CartaAutorizacion[]
     */
    public function getCartaautorizacion(): Collection
    {
        return $this->cartaautorizacion;
    }

    public function addCartaautorizacion(CartaAutorizacion $cartaautorizacion): self
    {
        if (!$this->cartaautorizacion->contains($cartaautorizacion)) {
            $this->cartaautorizacion[] = $cartaautorizacion;
            $cartaautorizacion->setIntervencionconservacion($this);
        }

        return $this;
    }

    public function removeCartaautorizacion(CartaAutorizacion $cartaautorizacion): self
    {
        if ($this->cartaautorizacion->contains($cartaautorizacion)) {
            $this->cartaautorizacion->removeElement($cartaautorizacion);
            // set the owning side to null (unless already changed)
            if ($cartaautorizacion->getIntervencionconservacion() === $this) {
                $cartaautorizacion->setIntervencionconservacion(null);
            }
        }

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

    public function getEspecialistaJefe(): ?Especialista
    {
        return $this->especialista_jefe;
    }

    public function setEspecialistaJefe(?Especialista $especialista_jefe): self
    {
        $this->especialista_jefe = $especialista_jefe;

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

    public function getTipointervencionobj(): ?TipoIntervencionObjeto
    {
        return $this->tipointervencionobj;
    }

    public function setTipointervencionobj(?TipoIntervencionObjeto $tipointervencionobj): self
    {
        $this->tipointervencionobj = $tipointervencionobj;

        return $this;
    }

    public function getCausaintervencionobj(): ?CausaIntervencionObjeto
    {
        return $this->causaintervencionobj;
    }

    public function setCausaintervencionobj(?CausaIntervencionObjeto $causaintervencionobj): self
    {
        $this->causaintervencionobj = $causaintervencionobj;

        return $this;
    }

    public function getTratamientoinsitu(): ?TratamientoInsitu
    {
        return $this->tratamientoinsitu;
    }

    public function setTratamientoinsitu(?TratamientoInsitu $tratamientoinsitu): self
    {
        $this->tratamientoinsitu = $tratamientoinsitu;

        return $this;
    }

    public function getTratamientolaboratorio(): ?TratamientoLaboratorio
    {
        return $this->tratamientolaboratorio;
    }

    public function setTratamientolaboratorio(?TratamientoLaboratorio $tratamientolaboratorio): self
    {
        $this->tratamientolaboratorio = $tratamientolaboratorio;

        return $this;
    }

    public function getTecnicaaplicada(): ?TecnicaAplicada
    {
        return $this->tecnicaaplicada;
    }

    public function setTecnicaaplicada(?TecnicaAplicada $tecnicaaplicada): self
    {
        $this->tecnicaaplicada = $tecnicaaplicada;

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
