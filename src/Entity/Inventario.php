<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation\Auditable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InventarioRepository")
 * @UniqueEntity(fields={"cod_inventario"}, message="Ya existe este Código de Inventario.")
 * @Auditable()
 */

class Inventario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="cod_inventario", type="string",  nullable=false, length=80, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú0-9 ]*$/",
     *     message="Debe de contener solo letras o números."
     * )
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $cod_inventario;

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
     * @var string
     * @ORM\Column(name="estado", type="string", nullable=true, length=30)
     * @Assert\Choice(choices={"Planificación","En Ejecución","Completado","Cancelado"})
     */
    protected $estado;

    /**
     * @ORM\ManyToOne(targetEntity = "Especialista", inversedBy = "inventariojefe")
     * @ORM\JoinColumn(name="especialistajefe_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Especialista Jefe (Responsable del Proyecto)")
     */
    protected $especialistainvejefe;

    /**
     * @ORM\ManyToMany(targetEntity="Especialista", inversedBy="inventarioParticipantes")
     */
    private $especialistasinvParticipantes;

    /**
     * @ORM\ManyToOne(targetEntity = "SitioPatrimonial", inversedBy = "inventario")
     * @ORM\JoinColumn(name="sitiopatrimonial_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Sitio Patrimonial")
     */
    protected $sitiopatrimonial;

    /**
     * @ORM\ManyToMany(targetEntity="FichaObjetoPatrimonial", inversedBy="invobjetospresentes")
     * @ORM\JoinTable(
     *     name="inventario_fichaobjeto",
     * )
     */
    private $objetospresentes;

    /**
     * @ORM\ManyToOne(targetEntity = "TipoInventario", inversedBy = "inventario")
     * @ORM\JoinColumn(name="tipoinventario_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Tipo de Inventario")
     */
    protected $tipoinventario;

    /**
     * @var string
     * @ORM\Column(name="autorizacion", type="string", nullable=true, length=30)
     * @Assert\Choice(choices={"Autorizado","No Autorizado","Pendiente"})
     */
    protected $autorizacion;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $faltantes;

    /**
     * @ORM\ManyToMany(targetEntity="FichaObjetoPatrimonial", inversedBy="inventarioobjetos")
     * @ORM\JoinColumn(nullable=true)
     */
    private $objetosfaltantes;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $descripcion_faltantes;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $causas_faltantes;

    /**
     * @ORM\OneToMany(targetEntity="OrdenInventario", mappedBy="inventario", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $ordeninventario;

    /**
     * @ORM\OneToMany(targetEntity="CartaAutorizacionInventario", mappedBy="inventario", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $cartaautorizacioninventario;

    public function __construct()
    {
        $this->especialistasinvParticipantes = new ArrayCollection();
        $this->objetosfaltantes = new ArrayCollection();
        $this->ordeninventario = new ArrayCollection();
        $this->cartaautorizacioninventario = new ArrayCollection();
        $this->objetospresentes = new ArrayCollection();
    }

    public function __toString() {

        return $this->getCodInventario();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodInventario(): ?string
    {
        return $this->cod_inventario;
    }

    public function setCodInventario(string $cod_inventario): self
    {
        $this->cod_inventario = $cod_inventario;

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

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(?string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getAutorizacion(): ?string
    {
        return $this->autorizacion;
    }

    public function setAutorizacion(?string $autorizacion): self
    {
        $this->autorizacion = $autorizacion;

        return $this;
    }

    public function getFaltantes(): ?bool
    {
        return $this->faltantes;
    }

    public function setFaltantes(?bool $faltantes): self
    {
        $this->faltantes = $faltantes;

        return $this;
    }

    public function getDescripcionFaltantes(): ?string
    {
        return $this->descripcion_faltantes;
    }

    public function setDescripcionFaltantes(?string $descripcion_faltantes): self
    {
        $this->descripcion_faltantes = $descripcion_faltantes;

        return $this;
    }

    public function getCausasFaltantes(): ?string
    {
        return $this->causas_faltantes;
    }

    public function setCausasFaltantes(?string $causas_faltantes): self
    {
        $this->causas_faltantes = $causas_faltantes;

        return $this;
    }

    public function getEspecialistainvejefe(): ?Especialista
    {
        return $this->especialistainvejefe;
    }

    public function setEspecialistainvejefe(?Especialista $especialistainvejefe): self
    {
        $this->especialistainvejefe = $especialistainvejefe;

        return $this;
    }

    /**
     * @return Collection|Especialista[]
     */
    public function getEspecialistasinvParticipantes(): Collection
    {
        return $this->especialistasinvParticipantes;
    }

    public function addEspecialistasinvParticipante(Especialista $especialistasinvParticipante): self
    {
        if (!$this->especialistasinvParticipantes->contains($especialistasinvParticipante)) {
            $this->especialistasinvParticipantes[] = $especialistasinvParticipante;
        }

        return $this;
    }

    public function removeEspecialistasinvParticipante(Especialista $especialistasinvParticipante): self
    {
        if ($this->especialistasinvParticipantes->contains($especialistasinvParticipante)) {
            $this->especialistasinvParticipantes->removeElement($especialistasinvParticipante);
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

    public function getTipoinventario(): ?TipoInventario
    {
        return $this->tipoinventario;
    }

    public function setTipoinventario(?TipoInventario $tipoinventario): self
    {
        $this->tipoinventario = $tipoinventario;

        return $this;
    }

    /**
     * @return Collection|FichaObjetoPatrimonial[]
     */
    public function getObjetosfaltantes(): Collection
    {
        return $this->objetosfaltantes;
    }

    public function addObjetosfaltante(FichaObjetoPatrimonial $objetosfaltante): self
    {
        if (!$this->objetosfaltantes->contains($objetosfaltante)) {
            $this->objetosfaltantes[] = $objetosfaltante;
        }

        return $this;
    }

    public function removeObjetosfaltante(FichaObjetoPatrimonial $objetosfaltante): self
    {
        if ($this->objetosfaltantes->contains($objetosfaltante)) {
            $this->objetosfaltantes->removeElement($objetosfaltante);
        }

        return $this;
    }

    /**
     * @return Collection|OrdenInventario[]
     */
    public function getOrdeninventario(): Collection
    {
        return $this->ordeninventario;
    }

    public function addOrdeninventario(OrdenInventario $ordeninventario): self
    {
        if (!$this->ordeninventario->contains($ordeninventario)) {
            $this->ordeninventario[] = $ordeninventario;
            $ordeninventario->setInventario($this);
        }

        return $this;
    }

    public function removeOrdeninventario(OrdenInventario $ordeninventario): self
    {
        if ($this->ordeninventario->contains($ordeninventario)) {
            $this->ordeninventario->removeElement($ordeninventario);
            // set the owning side to null (unless already changed)
            if ($ordeninventario->getInventario() === $this) {
                $ordeninventario->setInventario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CartaAutorizacionInventario[]
     */
    public function getCartaautorizacioninventario(): Collection
    {
        return $this->cartaautorizacioninventario;
    }

    public function addCartaautorizacioninventario(CartaAutorizacionInventario $cartaautorizacioninventario): self
    {
        if (!$this->cartaautorizacioninventario->contains($cartaautorizacioninventario)) {
            $this->cartaautorizacioninventario[] = $cartaautorizacioninventario;
            $cartaautorizacioninventario->setInventario($this);
        }

        return $this;
    }

    public function removeCartaautorizacioninventario(CartaAutorizacionInventario $cartaautorizacioninventario): self
    {
        if ($this->cartaautorizacioninventario->contains($cartaautorizacioninventario)) {
            $this->cartaautorizacioninventario->removeElement($cartaautorizacioninventario);
            // set the owning side to null (unless already changed)
            if ($cartaautorizacioninventario->getInventario() === $this) {
                $cartaautorizacioninventario->setInventario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FichaObjetoPatrimonial[]
     */
    public function getObjetospresentes(): Collection
    {
        return $this->objetospresentes;
    }

    public function addObjetospresente(FichaObjetoPatrimonial $objetospresente): self
    {
        if (!$this->objetospresentes->contains($objetospresente)) {
            $this->objetospresentes[] = $objetospresente;
        }

        return $this;
    }

    public function removeObjetospresente(FichaObjetoPatrimonial $objetospresente): self
    {
        if ($this->objetospresentes->contains($objetospresente)) {
            $this->objetospresentes->removeElement($objetospresente);
        }

        return $this;
    }
}
