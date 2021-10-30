<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation\Auditable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FichaObjetoPatrimonialRepository")
 * @UniqueEntity(fields={"codigoobjeto"}, message="Ya existe esta Ficha del Objeto Patrimonial.")
 * @Auditable()
 */

class FichaObjetoPatrimonial
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="codigoobjeto", type="string",  nullable=false, length=80, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú0-9 ]*$/",
     *     message="Debe de contener solo letras o números."
     * )
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $codigoobjeto;

    /**
     * @var string
     * @ORM\Column(name="keyword", type="string",  nullable=true, length=80)
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $keyword;

    /**
     * @var string
     * @ORM\Column(name="nombreobjeto", type="string",  nullable=false, length=100)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú0-9 ]*$/",
     *     message="Debe de contener solo letras o números."
     * )
     * @Assert\Length(min=1, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $nombreobjeto;

    /**
     * @var string
     * @ORM\Column(name="otronombreobjeto", type="string",  nullable=true, length=100)
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú0-9 ]*$/",
     *     message="Debe de contener solo letras o números."
     * )
     * @Assert\Length(min=1, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $otronombreobjeto;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $descripcion_tecnica;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $descripcion_visual;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $marcas_visibles;

    /**
     * @var string
     * @ORM\Column(name="autor", type="string",  nullable=true, length=100)
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú ]*$/",
     *     message="Debe de contener solo letras o números."
     * )
     * @Assert\Length(min=1, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $autor;

    /**
     * @ORM\ManyToMany(targetEntity="Especialista", inversedBy="fichaobjeto")
     */
    private $realizadopor;

    /**
     * @Assert\Type("\DateTimeInterface")
     * @ORM\Column(name="fecharealizacion", type="datetime",  nullable=true)
     */
    private $fecharealizacion;

    /**
     * @var string
     * @ORM\Column(name="fuepropiedad", type="string",  nullable=true, length=100)
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú0-9 ]*$/",
     *     message="Debe de contener solo letras o números."
     * )
     * @Assert\Length(min=1, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $fuepropiedad;

    /**
     * @ORM\ManyToOne(targetEntity = "Pais", inversedBy = "fichaobjeto")
     * @ORM\JoinColumn(name="pais_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un País.")
     */
    private $pais;

    /**
     * @var string
     * @ORM\Column(name="lugar_procedencia", type="string",  nullable=true, length=100)
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú0-9 ]*$/",
     *     message="Debe de contener solo letras o numeros."
     * )
     * @Assert\Length(min=1, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $lugar_procedencia;

    /**
     * @var string
     * @ORM\Column(name="propiedad_actual", type="string",  nullable=true, length=100)
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú0-9 ]*$/",
     *     message="Debe de contener solo letras o numeros."
     * )
     * @Assert\Length(min=1, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $propiedad_actual;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $hecho_historico_relacionado;

    /**
     * @var string
     * @ORM\Column(name="altura", type="string",  nullable=true, length=80)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo letras números."
     * )
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $altura;

    /**
     * @var string
     * @ORM\Column(name="ancho", type="string",  nullable=true, length=80)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo letras números."
     * )
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $ancho;

    /**
     * @var string
     * @ORM\Column(name="largo", type="string",  nullable=true, length=80)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo letras números."
     * )
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $largo;

    /**
     * @var string
     * @ORM\Column(name="grosor", type="string",  nullable=true, length=80)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo letras números."
     * )
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $grosor;

    /**
     * @var string
     * @ORM\Column(name="diametro", type="string",  nullable=true, length=80)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo letras números."
     * )
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $diametro;

    /**
     * @var string
     * @ORM\Column(name="peso", type="string",  nullable=true, length=80)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo letras números."
     * )
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $peso;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Clasificacion", inversedBy="fichaobjeto")
     */
    private $clasificacion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TipoMaterial", inversedBy="fichaobjeto")
     */
    private $tipomaterial;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubTipoMaterial", inversedBy="fichaobjeto")
     */
    private $subtipomaterial;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategoriaObjeto", inversedBy="fichaobjeto")
     */
    private $categoriaobjeto;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UsoFuncion", inversedBy="fichaobjeto")
     */
    private $usofuncion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Datacion", inversedBy="fichaobjeto")
     */
    private $datacion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Integridad", inversedBy="fichaobjeto")
     */
    private $integridad;

    /**
     * @var string
     * @ORM\Column(name="estado_conservacion", type="string", nullable=true, length=30)
     * @Assert\Choice(choices={"Buena","Regular","Mala"},  message="Debe seleccionar una Opción")
     */
    protected $estado_conservacion;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $expuesto_publico;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $lugares_exposicion;

    /**
     * @ORM\OneToMany(targetEntity="FotografiaObjeto", mappedBy="fichaobjeto", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $fotografiaobjeto;

    /**
     * @ORM\OneToMany(targetEntity="DibujoObjeto", mappedBy="fichaobjeto", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $dibujoobjeto;

    /**
     * @ORM\OneToMany(targetEntity="FotogrametriaObjeto", mappedBy="fichaobjeto", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $fotogrametriaobjeto;

    /**
     * @ORM\OneToMany(targetEntity="Modelo3DObjeto", mappedBy="fichaobjeto", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $modelo3dobjeto;

    /**
     * @ORM\OneToMany(targetEntity="BibliografiaObjeto", mappedBy="fichaobjeto", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $bibliografiaobjeto;

    /**
     * @ORM\OneToMany(targetEntity="PublicacionesObjeto", mappedBy="fichaobjeto", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $publicacionesobjeto;

    /**
     * @ORM\OneToMany(targetEntity="ReferenciaWebObjeto", mappedBy="fichaobjeto", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $referenciawebobjeto;

    /**
     * @ORM\ManyToOne(targetEntity = "SitioPatrimonial", inversedBy = "fichaobjetopatrimonial")
     * @ORM\JoinColumn(name="sitiopatrimonial_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Sitio Patrimonial")
     */
    protected $sitiopatrimonial;

    /**
     * @ORM\OneToMany(targetEntity="PortadaObjeto", mappedBy="fichaobjetopat", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $portadaobjeto;

    /**
     * @ORM\OneToMany(targetEntity="IntervencionConservacion", mappedBy="fichaobjeto")
     */
    protected $intervencionconservacion;

    /**
     * @ORM\ManyToMany(targetEntity="Inventario", mappedBy="objetosfaltantes")
     */
    private $inventarioobjetos;

    /**
     * @ORM\ManyToMany(targetEntity="Inventario", mappedBy="objetospresentes")
     */
    private $invobjetospresentes;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $new;

    public function __construct()
    {
        $this->new = true;
        $this->state = false;
        $this->realizadopor = new ArrayCollection();
        $this->fotografiaobjeto = new ArrayCollection();
        $this->dibujoobjeto = new ArrayCollection();
        $this->fotogrametriaobjeto = new ArrayCollection();
        $this->modelo3dobjeto = new ArrayCollection();
        $this->bibliografiaobjeto = new ArrayCollection();
        $this->publicacionesobjeto = new ArrayCollection();
        $this->referenciawebobjeto = new ArrayCollection();
        $this->portadaobjeto = new ArrayCollection();
        $this->intervencionconservacion = new ArrayCollection();
        $this->inventarioobjetos = new ArrayCollection();
        $this->invobjetospresentes = new ArrayCollection();
    }

    public function __toString() {

        return $this->getNombreobjeto();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigoobjeto(): ?string
    {
        return $this->codigoobjeto;
    }

    public function setCodigoobjeto(string $codigoobjeto): self
    {
        $this->codigoobjeto = $codigoobjeto;

        return $this;
    }

    public function getKeyword(): ?string
    {
        return $this->keyword;
    }

    public function setKeyword(?string $keyword): self
    {
        $this->keyword = $keyword;

        return $this;
    }

    public function getNombreobjeto(): ?string
    {
        return $this->nombreobjeto;
    }

    public function setNombreobjeto(string $nombreobjeto): self
    {
        $this->nombreobjeto = $nombreobjeto;

        return $this;
    }

    public function getOtronombreobjeto(): ?string
    {
        return $this->otronombreobjeto;
    }

    public function setOtronombreobjeto(?string $otronombreobjeto): self
    {
        $this->otronombreobjeto = $otronombreobjeto;

        return $this;
    }

    public function getDescripcionTecnica(): ?string
    {
        return $this->descripcion_tecnica;
    }

    public function setDescripcionTecnica(?string $descripcion_tecnica): self
    {
        $this->descripcion_tecnica = $descripcion_tecnica;

        return $this;
    }

    public function getDescripcionVisual(): ?string
    {
        return $this->descripcion_visual;
    }

    public function setDescripcionVisual(?string $descripcion_visual): self
    {
        $this->descripcion_visual = $descripcion_visual;

        return $this;
    }

    public function getMarcasVisibles(): ?bool
    {
        return $this->marcas_visibles;
    }

    public function setMarcasVisibles(?bool $marcas_visibles): self
    {
        $this->marcas_visibles = $marcas_visibles;

        return $this;
    }

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function setAutor(?string $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    public function getFecharealizacion(): ?\DateTimeInterface
    {
        return $this->fecharealizacion;
    }

    public function setFecharealizacion(?\DateTimeInterface $fecharealizacion): self
    {
        $this->fecharealizacion = $fecharealizacion;

        return $this;
    }

    public function getFuepropiedad(): ?string
    {
        return $this->fuepropiedad;
    }

    public function setFuepropiedad(?string $fuepropiedad): self
    {
        $this->fuepropiedad = $fuepropiedad;

        return $this;
    }

    public function getLugarProcedencia(): ?string
    {
        return $this->lugar_procedencia;
    }

    public function setLugarProcedencia(?string $lugar_procedencia): self
    {
        $this->lugar_procedencia = $lugar_procedencia;

        return $this;
    }

    public function getPropiedadActual(): ?string
    {
        return $this->propiedad_actual;
    }

    public function setPropiedadActual(?string $propiedad_actual): self
    {
        $this->propiedad_actual = $propiedad_actual;

        return $this;
    }

    public function getHechoHistoricoRelacionado(): ?string
    {
        return $this->hecho_historico_relacionado;
    }

    public function setHechoHistoricoRelacionado(?string $hecho_historico_relacionado): self
    {
        $this->hecho_historico_relacionado = $hecho_historico_relacionado;

        return $this;
    }

    public function getAltura(): ?string
    {
        return $this->altura;
    }

    public function setAltura(?string $altura): self
    {
        $this->altura = $altura;

        return $this;
    }

    public function getAncho(): ?string
    {
        return $this->ancho;
    }

    public function setAncho(?string $ancho): self
    {
        $this->ancho = $ancho;

        return $this;
    }

    public function getLargo(): ?string
    {
        return $this->largo;
    }

    public function setLargo(?string $largo): self
    {
        $this->largo = $largo;

        return $this;
    }

    public function getGrosor(): ?string
    {
        return $this->grosor;
    }

    public function setGrosor(?string $grosor): self
    {
        $this->grosor = $grosor;

        return $this;
    }

    public function getDiametro(): ?string
    {
        return $this->diametro;
    }

    public function setDiametro(?string $diametro): self
    {
        $this->diametro = $diametro;

        return $this;
    }

    public function getPeso(): ?string
    {
        return $this->peso;
    }

    public function setPeso(?string $peso): self
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * @return Collection|Especialista[]
     */
    public function getRealizadopor(): Collection
    {
        return $this->realizadopor;
    }

    public function addRealizadopor(Especialista $realizadopor): self
    {
        if (!$this->realizadopor->contains($realizadopor)) {
            $this->realizadopor[] = $realizadopor;
        }

        return $this;
    }

    public function removeRealizadopor(Especialista $realizadopor): self
    {
        if ($this->realizadopor->contains($realizadopor)) {
            $this->realizadopor->removeElement($realizadopor);
        }

        return $this;
    }

    public function getPais(): ?Pais
    {
        return $this->pais;
    }

    public function setPais(?Pais $pais): self
    {
        $this->pais = $pais;

        return $this;
    }

    public function getState(): ?bool
    {
        return $this->state;
    }

    public function setState(?bool $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getNew(): ?bool
    {
        return $this->new;
    }

    public function setNew(?bool $new): self
    {
        $this->new = $new;

        return $this;
    }

    public function getClasificacion(): ?Clasificacion
    {
        return $this->clasificacion;
    }

    public function setClasificacion(?Clasificacion $clasificacion): self
    {
        $this->clasificacion = $clasificacion;

        return $this;
    }

    public function getTipomaterial(): ?TipoMaterial
    {
        return $this->tipomaterial;
    }

    public function setTipomaterial(?TipoMaterial $tipomaterial): self
    {
        $this->tipomaterial = $tipomaterial;

        return $this;
    }

    public function getSubtipomaterial(): ?SubTipoMaterial
    {
        return $this->subtipomaterial;
    }

    public function setSubtipomaterial(?SubTipoMaterial $subtipomaterial): self
    {
        $this->subtipomaterial = $subtipomaterial;

        return $this;
    }

    public function getCategoriaobjeto(): ?CategoriaObjeto
    {
        return $this->categoriaobjeto;
    }

    public function setCategoriaobjeto(?CategoriaObjeto $categoriaobjeto): self
    {
        $this->categoriaobjeto = $categoriaobjeto;

        return $this;
    }

    public function getUsofuncion(): ?UsoFuncion
    {
        return $this->usofuncion;
    }

    public function setUsofuncion(?UsoFuncion $usofuncion): self
    {
        $this->usofuncion = $usofuncion;

        return $this;
    }

    public function getDatacion(): ?Datacion
    {
        return $this->datacion;
    }

    public function setDatacion(?Datacion $datacion): self
    {
        $this->datacion = $datacion;

        return $this;
    }

    public function getIntegridad(): ?Integridad
    {
        return $this->integridad;
    }

    public function setIntegridad(?Integridad $integridad): self
    {
        $this->integridad = $integridad;

        return $this;
    }

    public function getEstadoConservacion(): ?string
    {
        return $this->estado_conservacion;
    }

    public function setEstadoConservacion(?string $estado_conservacion): self
    {
        $this->estado_conservacion = $estado_conservacion;

        return $this;
    }

    public function getExpuestoPublico(): ?bool
    {
        return $this->expuesto_publico;
    }

    public function setExpuestoPublico(?bool $expuesto_publico): self
    {
        $this->expuesto_publico = $expuesto_publico;

        return $this;
    }

    public function getLugaresExposicion(): ?string
    {
        return $this->lugares_exposicion;
    }

    public function setLugaresExposicion(?string $lugares_exposicion): self
    {
        $this->lugares_exposicion = $lugares_exposicion;

        return $this;
    }

    /**
     * @return Collection|FotografiaObjeto[]
     */
    public function getFotografiaobjeto(): Collection
    {
        return $this->fotografiaobjeto;
    }

    public function addFotografiaobjeto(FotografiaObjeto $fotografiaobjeto): self
    {
        if (!$this->fotografiaobjeto->contains($fotografiaobjeto)) {
            $this->fotografiaobjeto[] = $fotografiaobjeto;
            $fotografiaobjeto->setFichaobjeto($this);
        }

        return $this;
    }

    public function removeFotografiaobjeto(FotografiaObjeto $fotografiaobjeto): self
    {
        if ($this->fotografiaobjeto->contains($fotografiaobjeto)) {
            $this->fotografiaobjeto->removeElement($fotografiaobjeto);
            // set the owning side to null (unless already changed)
            if ($fotografiaobjeto->getFichaobjeto() === $this) {
                $fotografiaobjeto->setFichaobjeto(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DibujoObjeto[]
     */
    public function getDibujoobjeto(): Collection
    {
        return $this->dibujoobjeto;
    }

    public function addDibujoobjeto(DibujoObjeto $dibujoobjeto): self
    {
        if (!$this->dibujoobjeto->contains($dibujoobjeto)) {
            $this->dibujoobjeto[] = $dibujoobjeto;
            $dibujoobjeto->setFichaobjeto($this);
        }

        return $this;
    }

    public function removeDibujoobjeto(DibujoObjeto $dibujoobjeto): self
    {
        if ($this->dibujoobjeto->contains($dibujoobjeto)) {
            $this->dibujoobjeto->removeElement($dibujoobjeto);
            // set the owning side to null (unless already changed)
            if ($dibujoobjeto->getFichaobjeto() === $this) {
                $dibujoobjeto->setFichaobjeto(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FotogrametriaObjeto[]
     */
    public function getFotogrametriaobjeto(): Collection
    {
        return $this->fotogrametriaobjeto;
    }

    public function addFotogrametriaobjeto(FotogrametriaObjeto $fotogrametriaobjeto): self
    {
        if (!$this->fotogrametriaobjeto->contains($fotogrametriaobjeto)) {
            $this->fotogrametriaobjeto[] = $fotogrametriaobjeto;
            $fotogrametriaobjeto->setFichaobjeto($this);
        }

        return $this;
    }

    public function removeFotogrametriaobjeto(FotogrametriaObjeto $fotogrametriaobjeto): self
    {
        if ($this->fotogrametriaobjeto->contains($fotogrametriaobjeto)) {
            $this->fotogrametriaobjeto->removeElement($fotogrametriaobjeto);
            // set the owning side to null (unless already changed)
            if ($fotogrametriaobjeto->getFichaobjeto() === $this) {
                $fotogrametriaobjeto->setFichaobjeto(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Modelo3DObjeto[]
     */
    public function getModelo3dobjeto(): Collection
    {
        return $this->modelo3dobjeto;
    }

    public function addModelo3dobjeto(Modelo3DObjeto $modelo3dobjeto): self
    {
        if (!$this->modelo3dobjeto->contains($modelo3dobjeto)) {
            $this->modelo3dobjeto[] = $modelo3dobjeto;
            $modelo3dobjeto->setFichaobjeto($this);
        }

        return $this;
    }

    public function removeModelo3dobjeto(Modelo3DObjeto $modelo3dobjeto): self
    {
        if ($this->modelo3dobjeto->contains($modelo3dobjeto)) {
            $this->modelo3dobjeto->removeElement($modelo3dobjeto);
            // set the owning side to null (unless already changed)
            if ($modelo3dobjeto->getFichaobjeto() === $this) {
                $modelo3dobjeto->setFichaobjeto(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BibliografiaObjeto[]
     */
    public function getBibliografiaobjeto(): Collection
    {
        return $this->bibliografiaobjeto;
    }

    public function addBibliografiaobjeto(BibliografiaObjeto $bibliografiaobjeto): self
    {
        if (!$this->bibliografiaobjeto->contains($bibliografiaobjeto)) {
            $this->bibliografiaobjeto[] = $bibliografiaobjeto;
            $bibliografiaobjeto->setFichaobjeto($this);
        }

        return $this;
    }

    public function removeBibliografiaobjeto(BibliografiaObjeto $bibliografiaobjeto): self
    {
        if ($this->bibliografiaobjeto->contains($bibliografiaobjeto)) {
            $this->bibliografiaobjeto->removeElement($bibliografiaobjeto);
            // set the owning side to null (unless already changed)
            if ($bibliografiaobjeto->getFichaobjeto() === $this) {
                $bibliografiaobjeto->setFichaobjeto(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PublicacionesObjeto[]
     */
    public function getPublicacionesobjeto(): Collection
    {
        return $this->publicacionesobjeto;
    }

    public function addPublicacionesobjeto(PublicacionesObjeto $publicacionesobjeto): self
    {
        if (!$this->publicacionesobjeto->contains($publicacionesobjeto)) {
            $this->publicacionesobjeto[] = $publicacionesobjeto;
            $publicacionesobjeto->setFichaobjeto($this);
        }

        return $this;
    }

    public function removePublicacionesobjeto(PublicacionesObjeto $publicacionesobjeto): self
    {
        if ($this->publicacionesobjeto->contains($publicacionesobjeto)) {
            $this->publicacionesobjeto->removeElement($publicacionesobjeto);
            // set the owning side to null (unless already changed)
            if ($publicacionesobjeto->getFichaobjeto() === $this) {
                $publicacionesobjeto->setFichaobjeto(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ReferenciaWebObjeto[]
     */
    public function getReferenciawebobjeto(): Collection
    {
        return $this->referenciawebobjeto;
    }

    public function addReferenciawebobjeto(ReferenciaWebObjeto $referenciawebobjeto): self
    {
        if (!$this->referenciawebobjeto->contains($referenciawebobjeto)) {
            $this->referenciawebobjeto[] = $referenciawebobjeto;
            $referenciawebobjeto->setFichaobjeto($this);
        }

        return $this;
    }

    public function removeReferenciawebobjeto(ReferenciaWebObjeto $referenciawebobjeto): self
    {
        if ($this->referenciawebobjeto->contains($referenciawebobjeto)) {
            $this->referenciawebobjeto->removeElement($referenciawebobjeto);
            // set the owning side to null (unless already changed)
            if ($referenciawebobjeto->getFichaobjeto() === $this) {
                $referenciawebobjeto->setFichaobjeto(null);
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

    /**
     * @return Collection|PortadaObjeto[]
     */
    public function getPortadaobjeto(): Collection
    {
        return $this->portadaobjeto;
    }

    public function addPortadaobjeto(PortadaObjeto $portadaobjeto): self
    {
        if (!$this->portadaobjeto->contains($portadaobjeto)) {
            $this->portadaobjeto[] = $portadaobjeto;
            $portadaobjeto->setFichaobjetopat($this);
        }

        return $this;
    }

    public function removePortadaobjeto(PortadaObjeto $portadaobjeto): self
    {
        if ($this->portadaobjeto->contains($portadaobjeto)) {
            $this->portadaobjeto->removeElement($portadaobjeto);
            // set the owning side to null (unless already changed)
            if ($portadaobjeto->getFichaobjetopat() === $this) {
                $portadaobjeto->setFichaobjetopat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|IntervencionConservacion[]
     */
    public function getIntervencionconservacion(): Collection
    {
        return $this->intervencionconservacion;
    }

    public function addIntervencionconservacion(IntervencionConservacion $intervencionconservacion): self
    {
        if (!$this->intervencionconservacion->contains($intervencionconservacion)) {
            $this->intervencionconservacion[] = $intervencionconservacion;
            $intervencionconservacion->setFichaobjeto($this);
        }

        return $this;
    }

    public function removeIntervencionconservacion(IntervencionConservacion $intervencionconservacion): self
    {
        if ($this->intervencionconservacion->contains($intervencionconservacion)) {
            $this->intervencionconservacion->removeElement($intervencionconservacion);
            // set the owning side to null (unless already changed)
            if ($intervencionconservacion->getFichaobjeto() === $this) {
                $intervencionconservacion->setFichaobjeto(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Inventario[]
     */
    public function getInventarioobjetos(): Collection
    {
        return $this->inventarioobjetos;
    }

    public function addInventarioobjeto(Inventario $inventarioobjeto): self
    {
        if (!$this->inventarioobjetos->contains($inventarioobjeto)) {
            $this->inventarioobjetos[] = $inventarioobjeto;
            $inventarioobjeto->addObjetosfaltante($this);
        }

        return $this;
    }

    public function removeInventarioobjeto(Inventario $inventarioobjeto): self
    {
        if ($this->inventarioobjetos->contains($inventarioobjeto)) {
            $this->inventarioobjetos->removeElement($inventarioobjeto);
            $inventarioobjeto->removeObjetosfaltante($this);
        }

        return $this;
    }

    /**
     * @return Collection|Inventario[]
     */
    public function getInvobjetospresentes(): Collection
    {
        return $this->invobjetospresentes;
    }

    public function addInvobjetospresente(Inventario $invobjetospresente): self
    {
        if (!$this->invobjetospresentes->contains($invobjetospresente)) {
            $this->invobjetospresentes[] = $invobjetospresente;
            $invobjetospresente->addObjetospresente($this);
        }

        return $this;
    }

    public function removeInvobjetospresente(Inventario $invobjetospresente): self
    {
        if ($this->invobjetospresentes->contains($invobjetospresente)) {
            $this->invobjetospresentes->removeElement($invobjetospresente);
            $invobjetospresente->removeObjetospresente($this);
        }

        return $this;
    }
}
