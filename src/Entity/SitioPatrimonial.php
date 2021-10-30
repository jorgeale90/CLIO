<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation\Auditable;

/**
 * @ORM\Table(name="sitio_patrimonial")
 * @ORM\Entity(repositoryClass="App\Repository\SitioPatrimonialRepository")
 * @UniqueEntity(fields={"codigo"}, message="Ya existe este Código de este Sitio Patrimonial.")
 * @Auditable()
 */

class SitioPatrimonial
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="codigo", type="string",  nullable=false, length=80, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú0-9 ]*$/",
     *     message="Debe de contener solo letras o números."
     * )
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $codigo;

    /**
     * @var string
     * @ORM\Column(name="ref_expediente", type="string",  nullable=false, length=80)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú0-9 ]*$/",
     *     message="Debe de contener solo letras o números."
     * )
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $ref_expediente;

    /**
     * @Assert\Type("\DateTimeInterface")
     * @ORM\Column(name="fechainscripcion", type="datetime",  nullable=true)
     */
    private $fechainscripcion;

    /**
     * @Assert\Type("\DateTimeInterface")
     * @ORM\Column(name="fechainicio", type="datetime",  nullable=true)
     */
    private $fecharegistro;

    /**
     * @var string
     * @ORM\Column(name="nombresitio", type="string",  nullable=false, length=100)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú0-9 ]*$/",
     *     message="Debe de contener solo letras o números."
     * )
     * @Assert\Length(min=1, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $nombre;

    /**
     * @var string
     * @ORM\Column(name="nombreotros", type="string",  nullable=true, length=100)
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú0-9 ]*$/",
     *     message="Debe de contener solo letras o números."
     * )
     * @Assert\Length(min=1, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $otros_nombre;

    /**
     * @var string
     * @ORM\Column(name="keyword", type="string",  nullable=true, length=80)
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $keyword;

    /**
     * @ORM\ManyToOne(targetEntity = "Categoria", inversedBy = "sitiopatrimonial")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Categoría.")
     */
    protected $categoria;

    /**
     * @ORM\ManyToOne(targetEntity = "TipoSitio", inversedBy = "sitiopatrimonial")
     * @ORM\JoinColumn(name="tipositio_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Tipo de Sitio Cultural.")
     */
    protected $tipositio;

    /**
     * @ORM\ManyToOne(targetEntity = "TipoSitioNatural", inversedBy = "sitiopatrimonial")
     * @ORM\JoinColumn(name="tipositionatural_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Tipo de Sitio Natural.")
     */
    protected $tipositionatural;

    /**
     * @ORM\ManyToOne(targetEntity = "Pais", inversedBy = "sitiopatrimonial")
     * @ORM\JoinColumn(name="pais_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un País.")
     */
    protected $pais;

    /**
     * @ORM\ManyToOne(targetEntity = "Provincia", inversedBy = "sitiopatrimonial")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Provincia.")
     */
    protected $provincia;

    /**
     * @ORM\ManyToOne(targetEntity = "Municipio", inversedBy = "sitiopatrimonial")
     * @ORM\JoinColumn(name="municipio_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Municipio.")
     */
    protected $municipio;

    /**
     * @var string
     * @ORM\Column(name="localidad", type="string",  nullable=true, length=100)
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú0-9 ]*$/",
     *     message="Debe de contener solo letras o numeros."
     * )
     * @Assert\Length(min=2, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $localidad;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $descripcion_general;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $caracteristicas_generales;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $demarcacion_visual;

    /**
     * @ORM\OneToMany(targetEntity="CoordenadasGPS", mappedBy="sitiopatrimonial", cascade={"remove","persist"})
     */
    private $coordenadasgps;

    /**
     * @ORM\OneToMany(targetEntity="CoordenadasUTM", mappedBy="sitiopatrimonial", cascade={"remove","persist"})
     */
    private $coordenadasutm;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $enfilaciones;

    /**
     * @ORM\OneToMany(targetEntity="Croquis", mappedBy="sitiopatrimonial", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $croquis;

    /**
     * @ORM\OneToMany(targetEntity="Planimetria", mappedBy="sitiopatrimonial", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $planimetria;

    /**
     * @ORM\OneToMany(targetEntity="Fotogrametria", mappedBy="sitiopatrimonial", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $fotogrametria;

    /**
     * @ORM\OneToMany(targetEntity="Fotografia", mappedBy="sitiopatrimonial", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $fotografias;

    /**
     * @ORM\OneToMany(targetEntity="Video", mappedBy="sitiopatrimonial", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $video;

    /**
     * @ORM\OneToMany(targetEntity="Modelo3D", mappedBy="sitiopatrimonial", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $modelo3d;

    /**
     * @ORM\OneToMany(targetEntity="Bibliografias", mappedBy="sitiopatrimonial", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $bibliografia;

    /**
     * @ORM\OneToMany(targetEntity="Publicaciones", mappedBy="sitiopatrimonial", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $publicaciones;

    /**
     * @ORM\OneToMany(targetEntity="ReferenciaWeb", mappedBy="sitiopatrimonial", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $referenciaweb;

    /**
     * @ORM\OneToMany(targetEntity="Intervencion", mappedBy="sitiopatrimonial")
     */
    protected $intervencion;

    /**
     * @ORM\OneToMany(targetEntity="Proyecto", mappedBy="sitiopatrimonial")
     */
    protected $proyecto;

    /**
     * @ORM\ManyToOne(targetEntity = "Contexto", inversedBy = "sitiopatrimonial")
     * @ORM\JoinColumn(name="contexto_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Contexto.")
     */
    protected $contexto;

    /**
     * @ORM\ManyToOne(targetEntity = "ZonaCostera", inversedBy = "sitiopatrimonial")
     * @ORM\JoinColumn(name="zonacostera_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Zona Costera.")
     */
    protected $zonacostera;

    /**
     * @ORM\ManyToOne(targetEntity = "Region", inversedBy = "sitiopatrimonial")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Region.")
     */
    protected $region;

    /**
     * @ORM\ManyToOne(targetEntity = "GeoSistema", inversedBy = "sitiopatrimonial")
     * @ORM\JoinColumn(name="geosistema_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un GeoSistema.")
     */
    protected $geosistema;

    /**
     * @ORM\ManyToOne(targetEntity = "ContextoCultural", inversedBy = "sitiopatrimonial")
     * @ORM\JoinColumn(name="contextocultural_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Contexto Cultural.")
     */
    protected $contextocultural;

    /**
     * @ORM\ManyToOne(targetEntity = "Datacion", inversedBy = "sitiopatrimonial")
     * @ORM\JoinColumn(name="datacion_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Datación.")
     */
    protected $datacion;

    /**
     * @Assert\Type("\DateTimeInterface")
     * @ORM\Column(name="fechaconocimiento", type="datetime",  nullable=true)
     */
    private $fechaconocimiento;

    /**
     * @ORM\ManyToMany(targetEntity="Especialista", inversedBy="sitioParticipantes")
     */
    private $especialistasParticipantes;

    /**
     * @ORM\ManyToOne(targetEntity = "Propiedad", inversedBy = "sitiopatrimonial")
     * @ORM\JoinColumn(name="propiedad_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Propiedad.")
     */
    protected $propiedad;

    /**
     * @var string
     * @ORM\Column(name="consejopopular", type="string",  nullable=true, length=100)
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú0-9 ]*$/",
     *     message="Debe de contener solo letras o números."
     * )
     * @Assert\Length(min=2, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $consejopopular;

    /**
     * @ORM\OneToMany(targetEntity="ZonaObjetoGPS", mappedBy="sitiopatrimonial", cascade={"remove","persist"})
     */
    private $zonaobjetogps;

    /**
     * @ORM\OneToMany(targetEntity="ZonaPatrimonialGPS", mappedBy="sitiopatrimonial", cascade={"remove","persist"})
     */
    private $zonapatrimonialgps;

    /**
     * @ORM\OneToMany(targetEntity="ZonaProteccionGPS", mappedBy="sitiopatrimonial", cascade={"remove","persist"})
     */
    private $zonaprotecciongps;

    /**
     * @ORM\OneToMany(targetEntity="ZonaInsertidumbreGPS", mappedBy="sitiopatrimonial", cascade={"remove","persist"})
     */
    private $zonainsertidumbregps;

    /**
     * @var string
     * @ORM\Column(name="areaobjeto", type="string",  nullable=true, length=100)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo números."
     * )
     * @Assert\Length(min=1, max=100, minMessage="Debe contener al menos {{ limit }} número", maxMessage="Debe contener a lo sumo {{ limit }} números")
     */
    private $areaobjeto;

    /**
     * @var string
     * @ORM\Column(name="areapatrimonial", type="string",  nullable=true, length=100)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo números."
     * )
     * @Assert\Length(min=1, max=100, minMessage="Debe contener al menos {{ limit }} número", maxMessage="Debe contener a lo sumo {{ limit }} números")
     */
    private $areapatrimonial;

    /**
     * @var string
     * @ORM\Column(name="areaproteccion", type="string",  nullable=true, length=100)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo números."
     * )
     * @Assert\Length(min=1, max=100, minMessage="Debe contener al menos {{ limit }} número", maxMessage="Debe contener a lo sumo {{ limit }} números")
     */
    private $areaproteccion;

    /**
     * @var string
     * @ORM\Column(name="areainsertidumbre", type="string",  nullable=true, length=100)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo números."
     * )
     * @Assert\Length(min=1, max=100, minMessage="Debe contener al menos {{ limit }} número", maxMessage="Debe contener a lo sumo {{ limit }} números")
     */
    private $areainsertidumbre;

    /**
     * @var string
     * @ORM\Column(name="maxaltura", type="string",  nullable=true, length=100)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo números."
     * )
     * @Assert\Length(min=1, max=100, minMessage="Debe contener al menos {{ limit }} número", maxMessage="Debe contener a lo sumo {{ limit }} números")
     */
    private $maxaltura;

    /**
     * @Assert\Type("\DateTimeInterface")
     * @ORM\Column(name="datacionrelaticadesde", type="datetime",  nullable=true)
     */
    private $datacionrelaticadesde;

    /**
     * @Assert\Type("\DateTimeInterface")
     * @ORM\Column(name="datacionrelaticahasta", type="datetime",  nullable=true)
     */
    private $datacionrelaticahasta;

    /**
     * @Assert\Type("\DateTimeInterface")
     * @ORM\Column(name="datacionabsoluta", type="datetime",  nullable=true)
     */
    private $datacionabsoluta;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $tipo_construccion;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $tipo_arquitectura;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $hecho_historico;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $descripcion_tecnica;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $referencia_documental;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $antecedentes_historicos;

    /**
     * @var string
     * @ORM\Column(name="cant_inventario", type="string",  nullable=true, length=80)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo letras números."
     * )
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $cant_inventario;

    /**
     * @var string
     * @ORM\Column(name="cant_intervenciones_const", type="string",  nullable=true, length=80)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo números."
     * )
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $cant_intervenciones_const;

    /**
     * @var string
     * @ORM\Column(name="cant_intervenciones_conserv", type="string",  nullable=true, length=80)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo números."
     * )
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $cant_intervenciones_conserv;

    /**
     * @var string
     * @ORM\Column(name="cant_objetos_patrim", type="string",  nullable=true, length=80)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo números."
     * )
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $cant_objetos_patrim;

    /**
     * @var string
     * @ORM\Column(name="promedio_visitas_diaria", type="string",  nullable=true, length=80)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo números."
     * )
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $promedio_visitas_diaria;

    /**
     * @var string
     * @ORM\Column(name="promedio_visitas_mensuales", type="string",  nullable=true, length=80)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo números."
     * )
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $promedio_visitas_mensuales;

    /**
     * @var string
     * @ORM\Column(name="promedio_visitas_anuales", type="string",  nullable=true, length=80)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo números."
     * )
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $promedio_visitas_anuales;

    /**
     * @var string
     * @ORM\Column(name="promedio_recaudacion", type="string",  nullable=true, length=80)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo números."
     * )
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $promedio_recaudacion;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $recibe_visita;

    /**
     * @var string
     * @ORM\Column(name="nivel_visitas", type="string", nullable=true, length=30)
     * @Assert\Choice(choices={"Alto","Medio","Bajo"},  message="Debe seleccionar una Opción")
     */
    protected $nivel_visitas;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $cerrado_publico;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $expoliado;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $dannado;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $inventarios;

    /**
     * @var string
     * @ORM\Column(name="nivel_antropizacion", type="string", nullable=true, length=30)
     * @Assert\Choice(choices={"Alta","Media","Baja"},  message="Debe seleccionar una Opción")
     */
    protected $nivel_antropizacion;

    /**
     * @var string
     * @ORM\Column(name="estado_conservacion", type="string", nullable=true, length=30)
     * @Assert\Choice(choices={"Buena","Regular","Mala"},  message="Debe seleccionar una Opción")
     */
    protected $estado_conservacion;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $degradacion;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $plan_manejo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $declarado;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $riesgos_potenciales;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $medidas_proteccion;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $medidas_seguridad;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $intervencion_construc;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $intervencion_arqueol;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $intervencion_conserv;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $estado_conserv;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $antropizacion;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $causa_degradacion;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=10000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $propuesta_actuacion;

    /**
     * @Assert\Type("\DateTimeInterface")
     * @ORM\Column(name="fecha_declaracion", type="datetime",  nullable=true)
     */
    private $fecha_declaracion;

    /**
     * @var string
     * @ORM\Column(name="no_expe_declaracion", type="string",  nullable=true, length=80)
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo números."
     * )
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $no_expe_declaracion;

    /**
     * @ORM\OneToMany(targetEntity="PlanManejo", mappedBy="sitiopatrimonial", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $plan;

    /**
     * @ORM\OneToMany(targetEntity="Declaracion", mappedBy="sitiopatrimonial", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $declaracion;

    /**
     * @ORM\OneToMany(targetEntity="FichaObjetoPatrimonial", mappedBy="sitiopatrimonial")
     */
    protected $fichaobjetopatrimonial;

    /**
     * @ORM\OneToMany(targetEntity="IntervencionConservacion", mappedBy="sitiopatrimonial")
     */
    protected $intervencionconservacion;

    /**
     * @ORM\OneToMany(targetEntity="PortadaSitio", mappedBy="sitiopatrimonial", orphanRemoval=true, cascade={"remove","persist"})
     */
    private $portadasitio;

    /**
     * @ORM\OneToMany(targetEntity="Inventario", mappedBy="sitiopatrimonial")
     */
    protected $inventario;

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
        $this->intervencion = new ArrayCollection();
        $this->fotografias = new ArrayCollection();
        $this->croquis = new ArrayCollection();
        $this->planimetria = new ArrayCollection();
        $this->coordenadasgps = new ArrayCollection();
        $this->fotogrametria = new ArrayCollection();
        $this->video = new ArrayCollection();
        $this->modelo3d = new ArrayCollection();
        $this->bibliografia = new ArrayCollection();
        $this->publicaciones = new ArrayCollection();
        $this->referenciaweb = new ArrayCollection();
        $this->coordenadasutm = new ArrayCollection();
        $this->especialistasParticipantes = new ArrayCollection();
        $this->zonaobjetogps = new ArrayCollection();
        $this->zonapatrimonialgps = new ArrayCollection();
        $this->zonaprotecciongps = new ArrayCollection();
        $this->zonainsertidumbregps = new ArrayCollection();
        $this->declaracion = new ArrayCollection();
        $this->plan = new ArrayCollection();
        $this->fichaobjetopatrimonial = new ArrayCollection();
        $this->intervencionconservacion = new ArrayCollection();
        $this->portadasitio = new ArrayCollection();
        $this->proyecto = new ArrayCollection();
        $this->inventario = new ArrayCollection();

    }

    public function __toString()
    {
        return " {$this->getCodigo()}, {$this->getNombre()} ";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getFechainscripcion(): ?\DateTimeInterface
    {
        return $this->fechainscripcion;
    }

    public function setFechainscripcion(\DateTimeInterface $fechainscripcion): self
    {
        $this->fechainscripcion = $fechainscripcion;

        return $this;
    }

    public function getFecharegistro(): ?\DateTimeInterface
    {
        return $this->fecharegistro;
    }

    public function setFecharegistro(\DateTimeInterface $fecharegistro): self
    {
        $this->fecharegistro = $fecharegistro;

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

    public function getOtrosNombre(): ?string
    {
        return $this->otros_nombre;
    }

    public function setOtrosNombre(string $otros_nombre): self
    {
        $this->otros_nombre = $otros_nombre;

        return $this;
    }

    public function getCaracteristicasGenerales(): ?string
    {
        return $this->caracteristicas_generales;
    }

    public function setCaracteristicasGenerales(string $caracteristicas_generales): self
    {
        $this->caracteristicas_generales = $caracteristicas_generales;

        return $this;
    }

    public function getDemarcacionVisual(): ?string
    {
        return $this->demarcacion_visual;
    }

    public function setDemarcacionVisual(string $demarcacion_visual): self
    {
        $this->demarcacion_visual = $demarcacion_visual;

        return $this;
    }

    public function getEnfilaciones(): ?string
    {
        return $this->enfilaciones;
    }

    public function setEnfilaciones(string $enfilaciones): self
    {
        $this->enfilaciones = $enfilaciones;

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

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getTipositio(): ?TipoSitio
    {
        return $this->tipositio;
    }

    public function setTipositio(?TipoSitio $tipositio): self
    {
        $this->tipositio = $tipositio;

        return $this;
    }

    public function getTipositionatural(): ?TipoSitioNatural
    {
        return $this->tipositionatural;
    }

    public function setTipositionatural(?TipoSitioNatural $tipositionatural): self
    {
        $this->tipositionatural = $tipositionatural;

        return $this;
    }

    public function getProvincia(): ?Provincia
    {
        return $this->provincia;
    }

    public function setProvincia(?Provincia $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getMunicipio(): ?Municipio
    {
        return $this->municipio;
    }

    public function setMunicipio(?Municipio $municipio): self
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * @return Collection|Croquis[]
     */
    public function getCroquis(): Collection
    {
        return $this->croquis;
    }

    public function addCroqui(Croquis $croqui): self
    {
        if (!$this->croquis->contains($croqui)) {
            $this->croquis[] = $croqui;
            $croqui->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeCroqui(Croquis $croqui): self
    {
        if ($this->croquis->contains($croqui)) {
            $this->croquis->removeElement($croqui);
            // set the owning side to null (unless already changed)
            if ($croqui->getSitiopatrimonial() === $this) {
                $croqui->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Planimetria[]
     */
    public function getPlanimetria(): Collection
    {
        return $this->planimetria;
    }

    public function addPlanimetrium(Planimetria $planimetrium): self
    {
        if (!$this->planimetria->contains($planimetrium)) {
            $this->planimetria[] = $planimetrium;
            $planimetrium->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removePlanimetrium(Planimetria $planimetrium): self
    {
        if ($this->planimetria->contains($planimetrium)) {
            $this->planimetria->removeElement($planimetrium);
            // set the owning side to null (unless already changed)
            if ($planimetrium->getSitiopatrimonial() === $this) {
                $planimetrium->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Fotografia[]
     */
    public function getFotografias(): Collection
    {
        return $this->fotografias;
    }

    public function addFotografia(Fotografia $fotografia): self
    {
        if (!$this->fotografias->contains($fotografia)) {
            $this->fotografias[] = $fotografia;
            $fotografia->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeFotografia(Fotografia $fotografia): self
    {
        if ($this->fotografias->contains($fotografia)) {
            $this->fotografias->removeElement($fotografia);
            // set the owning side to null (unless already changed)
            if ($fotografia->getSitiopatrimonial() === $this) {
                $fotografia->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Intervencion[]
     */
    public function getIntervencion(): Collection
    {
        return $this->intervencion;
    }

    public function addIntervencion(Intervencion $intervencion): self
    {
        if (!$this->intervencion->contains($intervencion)) {
            $this->intervencion[] = $intervencion;
            $intervencion->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeIntervencion(Intervencion $intervencion): self
    {
        if ($this->intervencion->contains($intervencion)) {
            $this->intervencion->removeElement($intervencion);
            // set the owning side to null (unless already changed)
            if ($intervencion->getSitiopatrimonial() === $this) {
                $intervencion->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CoordenadasGPS[]
     */
    public function getCoordenadasgps(): Collection
    {
        return $this->coordenadasgps;
    }

    public function addCoordenadasgp(CoordenadasGPS $coordenadasgp): self
    {
        if (!$this->coordenadasgps->contains($coordenadasgp)) {
            $this->coordenadasgps[] = $coordenadasgp;
            $coordenadasgp->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeCoordenadasgp(CoordenadasGPS $coordenadasgp): self
    {
        if ($this->coordenadasgps->contains($coordenadasgp)) {
            $this->coordenadasgps->removeElement($coordenadasgp);
            // set the owning side to null (unless already changed)
            if ($coordenadasgp->getSitiopatrimonial() === $this) {
                $coordenadasgp->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad): self
    {
        $this->localidad = $localidad;

        return $this;
    }

    public function getContexto(): ?Contexto
    {
        return $this->contexto;
    }

    public function setContexto(?Contexto $contexto): self
    {
        $this->contexto = $contexto;

        return $this;
    }

    public function getZonacostera(): ?ZonaCostera
    {
        return $this->zonacostera;
    }

    public function setZonacostera(?ZonaCostera $zonacostera): self
    {
        $this->zonacostera = $zonacostera;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getGeosistema(): ?GeoSistema
    {
        return $this->geosistema;
    }

    public function setGeosistema(?GeoSistema $geosistema): self
    {
        $this->geosistema = $geosistema;

        return $this;
    }

    public function getContextocultural(): ?ContextoCultural
    {
        return $this->contextocultural;
    }

    public function setContextocultural(?ContextoCultural $contextocultural): self
    {
        $this->contextocultural = $contextocultural;

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

    /**
     * @return Collection|Fotogrametria[]
     */
    public function getFotogrametria(): Collection
    {
        return $this->fotogrametria;
    }

    public function addFotogrametrium(Fotogrametria $fotogrametrium): self
    {
        if (!$this->fotogrametria->contains($fotogrametrium)) {
            $this->fotogrametria[] = $fotogrametrium;
            $fotogrametrium->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeFotogrametrium(Fotogrametria $fotogrametrium): self
    {
        if ($this->fotogrametria->contains($fotogrametrium)) {
            $this->fotogrametria->removeElement($fotogrametrium);
            // set the owning side to null (unless already changed)
            if ($fotogrametrium->getSitiopatrimonial() === $this) {
                $fotogrametrium->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideo(): Collection
    {
        return $this->video;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->video->contains($video)) {
            $this->video[] = $video;
            $video->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->video->contains($video)) {
            $this->video->removeElement($video);
            // set the owning side to null (unless already changed)
            if ($video->getSitiopatrimonial() === $this) {
                $video->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Modelo3D[]
     */
    public function getModelo3d(): Collection
    {
        return $this->modelo3d;
    }

    public function addModelo3d(Modelo3D $modelo3d): self
    {
        if (!$this->modelo3d->contains($modelo3d)) {
            $this->modelo3d[] = $modelo3d;
            $modelo3d->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeModelo3d(Modelo3D $modelo3d): self
    {
        if ($this->modelo3d->contains($modelo3d)) {
            $this->modelo3d->removeElement($modelo3d);
            // set the owning side to null (unless already changed)
            if ($modelo3d->getSitiopatrimonial() === $this) {
                $modelo3d->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Bibliografias[]
     */
    public function getBibliografia(): Collection
    {
        return $this->bibliografia;
    }

    public function addBibliografium(Bibliografias $bibliografium): self
    {
        if (!$this->bibliografia->contains($bibliografium)) {
            $this->bibliografia[] = $bibliografium;
            $bibliografium->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeBibliografium(Bibliografias $bibliografium): self
    {
        if ($this->bibliografia->contains($bibliografium)) {
            $this->bibliografia->removeElement($bibliografium);
            // set the owning side to null (unless already changed)
            if ($bibliografium->getSitiopatrimonial() === $this) {
                $bibliografium->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Publicaciones[]
     */
    public function getPublicaciones(): Collection
    {
        return $this->publicaciones;
    }

    public function addPublicacione(Publicaciones $publicacione): self
    {
        if (!$this->publicaciones->contains($publicacione)) {
            $this->publicaciones[] = $publicacione;
            $publicacione->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removePublicacione(Publicaciones $publicacione): self
    {
        if ($this->publicaciones->contains($publicacione)) {
            $this->publicaciones->removeElement($publicacione);
            // set the owning side to null (unless already changed)
            if ($publicacione->getSitiopatrimonial() === $this) {
                $publicacione->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ReferenciaWeb[]
     */
    public function getReferenciaweb(): Collection
    {
        return $this->referenciaweb;
    }

    public function addReferenciaweb(ReferenciaWeb $referenciaweb): self
    {
        if (!$this->referenciaweb->contains($referenciaweb)) {
            $this->referenciaweb[] = $referenciaweb;
            $referenciaweb->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeReferenciaweb(ReferenciaWeb $referenciaweb): self
    {
        if ($this->referenciaweb->contains($referenciaweb)) {
            $this->referenciaweb->removeElement($referenciaweb);
            // set the owning side to null (unless already changed)
            if ($referenciaweb->getSitiopatrimonial() === $this) {
                $referenciaweb->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    public function getFechaconocimiento(): ?\DateTimeInterface
    {
        return $this->fechaconocimiento;
    }

    public function setFechaconocimiento(\DateTimeInterface $fechaconocimiento): self
    {
        $this->fechaconocimiento = $fechaconocimiento;

        return $this;
    }

    /**
     * @return Collection|CoordenadasUTM[]
     */
    public function getCoordenadasutm(): Collection
    {
        return $this->coordenadasutm;
    }

    public function addCoordenadasutm(CoordenadasUTM $coordenadasutm): self
    {
        if (!$this->coordenadasutm->contains($coordenadasutm)) {
            $this->coordenadasutm[] = $coordenadasutm;
            $coordenadasutm->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeCoordenadasutm(CoordenadasUTM $coordenadasutm): self
    {
        if ($this->coordenadasutm->contains($coordenadasutm)) {
            $this->coordenadasutm->removeElement($coordenadasutm);
            // set the owning side to null (unless already changed)
            if ($coordenadasutm->getSitiopatrimonial() === $this) {
                $coordenadasutm->setSitiopatrimonial(null);
            }
        }

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

    public function getPais(): ?Pais
    {
        return $this->pais;
    }

    public function setPais(?Pais $pais): self
    {
        $this->pais = $pais;

        return $this;
    }

    public function getDescripcionGeneral(): ?string
    {
        return $this->descripcion_general;
    }

    public function setDescripcionGeneral(string $descripcion_general): self
    {
        $this->descripcion_general = $descripcion_general;

        return $this;
    }

    public function getRefExpediente(): ?string
    {
        return $this->ref_expediente;
    }

    public function setRefExpediente(string $ref_expediente): self
    {
        $this->ref_expediente = $ref_expediente;

        return $this;
    }

    public function getPropiedad(): ?Propiedad
    {
        return $this->propiedad;
    }

    public function setPropiedad(?Propiedad $propiedad): self
    {
        $this->propiedad = $propiedad;

        return $this;
    }

    public function getConsejopopular(): ?string
    {
        return $this->consejopopular;
    }

    public function setConsejopopular(string $consejopopular): self
    {
        $this->consejopopular = $consejopopular;

        return $this;
    }

    /**
     * @return Collection|ZonaObjetoGPS[]
     */
    public function getZonaobjetogps(): Collection
    {
        return $this->zonaobjetogps;
    }

    public function addZonaobjetogp(ZonaObjetoGPS $zonaobjetogp): self
    {
        if (!$this->zonaobjetogps->contains($zonaobjetogp)) {
            $this->zonaobjetogps[] = $zonaobjetogp;
            $zonaobjetogp->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeZonaobjetogp(ZonaObjetoGPS $zonaobjetogp): self
    {
        if ($this->zonaobjetogps->contains($zonaobjetogp)) {
            $this->zonaobjetogps->removeElement($zonaobjetogp);
            // set the owning side to null (unless already changed)
            if ($zonaobjetogp->getSitiopatrimonial() === $this) {
                $zonaobjetogp->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ZonaPatrimonialGPS[]
     */
    public function getZonapatrimonialgps(): Collection
    {
        return $this->zonapatrimonialgps;
    }

    public function addZonapatrimonialgp(ZonaPatrimonialGPS $zonapatrimonialgp): self
    {
        if (!$this->zonapatrimonialgps->contains($zonapatrimonialgp)) {
            $this->zonapatrimonialgps[] = $zonapatrimonialgp;
            $zonapatrimonialgp->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeZonapatrimonialgp(ZonaPatrimonialGPS $zonapatrimonialgp): self
    {
        if ($this->zonapatrimonialgps->contains($zonapatrimonialgp)) {
            $this->zonapatrimonialgps->removeElement($zonapatrimonialgp);
            // set the owning side to null (unless already changed)
            if ($zonapatrimonialgp->getSitiopatrimonial() === $this) {
                $zonapatrimonialgp->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ZonaProteccionGPS[]
     */
    public function getZonaprotecciongps(): Collection
    {
        return $this->zonaprotecciongps;
    }

    public function addZonaprotecciongp(ZonaProteccionGPS $zonaprotecciongp): self
    {
        if (!$this->zonaprotecciongps->contains($zonaprotecciongp)) {
            $this->zonaprotecciongps[] = $zonaprotecciongp;
            $zonaprotecciongp->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeZonaprotecciongp(ZonaProteccionGPS $zonaprotecciongp): self
    {
        if ($this->zonaprotecciongps->contains($zonaprotecciongp)) {
            $this->zonaprotecciongps->removeElement($zonaprotecciongp);
            // set the owning side to null (unless already changed)
            if ($zonaprotecciongp->getSitiopatrimonial() === $this) {
                $zonaprotecciongp->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ZonaInsertidumbreGPS[]
     */
    public function getZonainsertidumbregps(): Collection
    {
        return $this->zonainsertidumbregps;
    }

    public function addZonainsertidumbregp(ZonaInsertidumbreGPS $zonainsertidumbregp): self
    {
        if (!$this->zonainsertidumbregps->contains($zonainsertidumbregp)) {
            $this->zonainsertidumbregps[] = $zonainsertidumbregp;
            $zonainsertidumbregp->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeZonainsertidumbregp(ZonaInsertidumbreGPS $zonainsertidumbregp): self
    {
        if ($this->zonainsertidumbregps->contains($zonainsertidumbregp)) {
            $this->zonainsertidumbregps->removeElement($zonainsertidumbregp);
            // set the owning side to null (unless already changed)
            if ($zonainsertidumbregp->getSitiopatrimonial() === $this) {
                $zonainsertidumbregp->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    public function getAreaobjeto(): ?string
    {
        return $this->areaobjeto;
    }

    public function setAreaobjeto(?string $areaobjeto): self
    {
        $this->areaobjeto = $areaobjeto;

        return $this;
    }

    public function getAreapatrimonial(): ?string
    {
        return $this->areapatrimonial;
    }

    public function setAreapatrimonial(?string $areapatrimonial): self
    {
        $this->areapatrimonial = $areapatrimonial;

        return $this;
    }

    public function getAreaproteccion(): ?string
    {
        return $this->areaproteccion;
    }

    public function setAreaproteccion(?string $areaproteccion): self
    {
        $this->areaproteccion = $areaproteccion;

        return $this;
    }

    public function getAreainsertidumbre(): ?string
    {
        return $this->areainsertidumbre;
    }

    public function setAreainsertidumbre(?string $areainsertidumbre): self
    {
        $this->areainsertidumbre = $areainsertidumbre;

        return $this;
    }

    public function getMaxaltura(): ?string
    {
        return $this->maxaltura;
    }

    public function setMaxaltura(?string $maxaltura): self
    {
        $this->maxaltura = $maxaltura;

        return $this;
    }

    public function getDatacionrelaticadesde(): ?\DateTimeInterface
    {
        return $this->datacionrelaticadesde;
    }

    public function setDatacionrelaticadesde(?\DateTimeInterface $datacionrelaticadesde): self
    {
        $this->datacionrelaticadesde = $datacionrelaticadesde;

        return $this;
    }

    public function getDatacionrelaticahasta(): ?\DateTimeInterface
    {
        return $this->datacionrelaticahasta;
    }

    public function setDatacionrelaticahasta(?\DateTimeInterface $datacionrelaticahasta): self
    {
        $this->datacionrelaticahasta = $datacionrelaticahasta;

        return $this;
    }

    public function getDatacionabsoluta(): ?\DateTimeInterface
    {
        return $this->datacionabsoluta;
    }

    public function setDatacionabsoluta(?\DateTimeInterface $datacionabsoluta): self
    {
        $this->datacionabsoluta = $datacionabsoluta;

        return $this;
    }

    public function getTipoConstruccion(): ?string
    {
        return $this->tipo_construccion;
    }

    public function setTipoConstruccion(?string $tipo_construccion): self
    {
        $this->tipo_construccion = $tipo_construccion;

        return $this;
    }

    public function getHechoHistorico(): ?string
    {
        return $this->hecho_historico;
    }

    public function setHechoHistorico(?string $hecho_historico): self
    {
        $this->hecho_historico = $hecho_historico;

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

    public function getTipoArquitectura(): ?string
    {
        return $this->tipo_arquitectura;
    }

    public function setTipoArquitectura(?string $tipo_arquitectura): self
    {
        $this->tipo_arquitectura = $tipo_arquitectura;

        return $this;
    }

    public function getReferenciaDocumental(): ?bool
    {
        return $this->referencia_documental;
    }

    public function setReferenciaDocumental(?bool $referencia_documental): self
    {
        $this->referencia_documental = $referencia_documental;

        return $this;
    }

    public function getAntecedentesHistoricos(): ?string
    {
        return $this->antecedentes_historicos;
    }

    public function setAntecedentesHistoricos(?string $antecedentes_historicos): self
    {
        $this->antecedentes_historicos = $antecedentes_historicos;

        return $this;
    }

    public function getCantInventario(): ?string
    {
        return $this->cant_inventario;
    }

    public function setCantInventario(?string $cant_inventario): self
    {
        $this->cant_inventario = $cant_inventario;

        return $this;
    }

    public function getCantIntervencionesConst(): ?string
    {
        return $this->cant_intervenciones_const;
    }

    public function setCantIntervencionesConst(?string $cant_intervenciones_const): self
    {
        $this->cant_intervenciones_const = $cant_intervenciones_const;

        return $this;
    }

    public function getCantIntervencionesConserv(): ?string
    {
        return $this->cant_intervenciones_conserv;
    }

    public function setCantIntervencionesConserv(?string $cant_intervenciones_conserv): self
    {
        $this->cant_intervenciones_conserv = $cant_intervenciones_conserv;

        return $this;
    }

    public function getCantObjetosPatrim(): ?string
    {
        return $this->cant_objetos_patrim;
    }

    public function setCantObjetosPatrim(?string $cant_objetos_patrim): self
    {
        $this->cant_objetos_patrim = $cant_objetos_patrim;

        return $this;
    }

    public function getPromedioVisitasDiaria(): ?string
    {
        return $this->promedio_visitas_diaria;
    }

    public function setPromedioVisitasDiaria(?string $promedio_visitas_diaria): self
    {
        $this->promedio_visitas_diaria = $promedio_visitas_diaria;

        return $this;
    }

    public function getPromedioVisitasMensuales(): ?string
    {
        return $this->promedio_visitas_mensuales;
    }

    public function setPromedioVisitasMensuales(?string $promedio_visitas_mensuales): self
    {
        $this->promedio_visitas_mensuales = $promedio_visitas_mensuales;

        return $this;
    }

    public function getPromedioVisitasAnuales(): ?string
    {
        return $this->promedio_visitas_anuales;
    }

    public function setPromedioVisitasAnuales(?string $promedio_visitas_anuales): self
    {
        $this->promedio_visitas_anuales = $promedio_visitas_anuales;

        return $this;
    }

    public function getPromedioRecaudacion(): ?string
    {
        return $this->promedio_recaudacion;
    }

    public function setPromedioRecaudacion(?string $promedio_recaudacion): self
    {
        $this->promedio_recaudacion = $promedio_recaudacion;

        return $this;
    }

    public function getRecibeVisita(): ?bool
    {
        return $this->recibe_visita;
    }

    public function setRecibeVisita(?bool $recibe_visita): self
    {
        $this->recibe_visita = $recibe_visita;

        return $this;
    }

    public function getNivelVisitas(): ?string
    {
        return $this->nivel_visitas;
    }

    public function setNivelVisitas(string $nivel_visitas): self
    {
        $this->nivel_visitas = $nivel_visitas;

        return $this;
    }

    public function getCerradoPublico(): ?bool
    {
        return $this->cerrado_publico;
    }

    public function setCerradoPublico(?bool $cerrado_publico): self
    {
        $this->cerrado_publico = $cerrado_publico;

        return $this;
    }

    public function getExpoliado(): ?bool
    {
        return $this->expoliado;
    }

    public function setExpoliado(?bool $expoliado): self
    {
        $this->expoliado = $expoliado;

        return $this;
    }

    public function getDannado(): ?bool
    {
        return $this->dannado;
    }

    public function setDannado(?bool $dannado): self
    {
        $this->dannado = $dannado;

        return $this;
    }

    public function getInventarios(): ?bool
    {
        return $this->inventarios;
    }

    public function setInventarios(?bool $inventarios): self
    {
        $this->inventarios = $inventarios;

        return $this;
    }

    public function getNivelAntropizacion(): ?string
    {
        return $this->nivel_antropizacion;
    }

    public function setNivelAntropizacion(?string $nivel_antropizacion): self
    {
        $this->nivel_antropizacion = $nivel_antropizacion;

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

    public function getDegradacion(): ?bool
    {
        return $this->degradacion;
    }

    public function setDegradacion(?bool $degradacion): self
    {
        $this->degradacion = $degradacion;

        return $this;
    }

    public function getDeclarado(): ?bool
    {
        return $this->declarado;
    }

    public function setDeclarado(?bool $declarado): self
    {
        $this->declarado = $declarado;

        return $this;
    }

    public function getRiesgosPotenciales(): ?string
    {
        return $this->riesgos_potenciales;
    }

    public function setRiesgosPotenciales(?string $riesgos_potenciales): self
    {
        $this->riesgos_potenciales = $riesgos_potenciales;

        return $this;
    }

    public function getMedidasProteccion(): ?string
    {
        return $this->medidas_proteccion;
    }

    public function setMedidasProteccion(?string $medidas_proteccion): self
    {
        $this->medidas_proteccion = $medidas_proteccion;

        return $this;
    }

    public function getMedidasSeguridad(): ?string
    {
        return $this->medidas_seguridad;
    }

    public function setMedidasSeguridad(?string $medidas_seguridad): self
    {
        $this->medidas_seguridad = $medidas_seguridad;

        return $this;
    }

    public function getIntervencionConstruc(): ?bool
    {
        return $this->intervencion_construc;
    }

    public function setIntervencionConstruc(?bool $intervencion_construc): self
    {
        $this->intervencion_construc = $intervencion_construc;

        return $this;
    }

    public function getIntervencionArqueol(): ?bool
    {
        return $this->intervencion_arqueol;
    }

    public function setIntervencionArqueol(?bool $intervencion_arqueol): self
    {
        $this->intervencion_arqueol = $intervencion_arqueol;

        return $this;
    }

    public function getIntervencionConserv(): ?bool
    {
        return $this->intervencion_conserv;
    }

    public function setIntervencionConserv(?bool $intervencion_conserv): self
    {
        $this->intervencion_conserv = $intervencion_conserv;

        return $this;
    }

    public function getEstadoConserv(): ?string
    {
        return $this->estado_conserv;
    }

    public function setEstadoConserv(?string $estado_conserv): self
    {
        $this->estado_conserv = $estado_conserv;

        return $this;
    }

    public function getAntropizacion(): ?string
    {
        return $this->antropizacion;
    }

    public function setAntropizacion(?string $antropizacion): self
    {
        $this->antropizacion = $antropizacion;

        return $this;
    }

    public function getCausaDegradacion(): ?string
    {
        return $this->causa_degradacion;
    }

    public function setCausaDegradacion(?string $causa_degradacion): self
    {
        $this->causa_degradacion = $causa_degradacion;

        return $this;
    }

    public function getPropuestaActuacion(): ?string
    {
        return $this->propuesta_actuacion;
    }

    public function setPropuestaActuacion(?string $propuesta_actuacion): self
    {
        $this->propuesta_actuacion = $propuesta_actuacion;

        return $this;
    }

    public function getFechaDeclaracion(): ?\DateTimeInterface
    {
        return $this->fecha_declaracion;
    }

    public function setFechaDeclaracion(?\DateTimeInterface $fecha_declaracion): self
    {
        $this->fecha_declaracion = $fecha_declaracion;

        return $this;
    }

    public function getNoExpeDeclaracion(): ?string
    {
        return $this->no_expe_declaracion;
    }

    public function setNoExpeDeclaracion(?string $no_expe_declaracion): self
    {
        $this->no_expe_declaracion = $no_expe_declaracion;

        return $this;
    }

    /**
     * @return Collection|Declaracion[]
     */
    public function getDeclaracion(): Collection
    {
        return $this->declaracion;
    }

    public function addDeclaracion(Declaracion $declaracion): self
    {
        if (!$this->declaracion->contains($declaracion)) {
            $this->declaracion[] = $declaracion;
            $declaracion->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeDeclaracion(Declaracion $declaracion): self
    {
        if ($this->declaracion->contains($declaracion)) {
            $this->declaracion->removeElement($declaracion);
            // set the owning side to null (unless already changed)
            if ($declaracion->getSitiopatrimonial() === $this) {
                $declaracion->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    public function getPlanManejo(): ?bool
    {
        return $this->plan_manejo;
    }

    public function setPlanManejo(?bool $plan_manejo): self
    {
        $this->plan_manejo = $plan_manejo;

        return $this;
    }

    /**
     * @return Collection|PlanManejo[]
     */
    public function getPlan(): Collection
    {
        return $this->plan;
    }

    public function addPlan(PlanManejo $plan): self
    {
        if (!$this->plan->contains($plan)) {
            $this->plan[] = $plan;
            $plan->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removePlan(PlanManejo $plan): self
    {
        if ($this->plan->contains($plan)) {
            $this->plan->removeElement($plan);
            // set the owning side to null (unless already changed)
            if ($plan->getSitiopatrimonial() === $this) {
                $plan->setSitiopatrimonial(null);
            }
        }

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

    /**
     * @return Collection|FichaObjetoPatrimonial[]
     */
    public function getFichaobjetopatrimonial(): Collection
    {
        return $this->fichaobjetopatrimonial;
    }

    public function addFichaobjetopatrimonial(FichaObjetoPatrimonial $fichaobjetopatrimonial): self
    {
        if (!$this->fichaobjetopatrimonial->contains($fichaobjetopatrimonial)) {
            $this->fichaobjetopatrimonial[] = $fichaobjetopatrimonial;
            $fichaobjetopatrimonial->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeFichaobjetopatrimonial(FichaObjetoPatrimonial $fichaobjetopatrimonial): self
    {
        if ($this->fichaobjetopatrimonial->contains($fichaobjetopatrimonial)) {
            $this->fichaobjetopatrimonial->removeElement($fichaobjetopatrimonial);
            // set the owning side to null (unless already changed)
            if ($fichaobjetopatrimonial->getSitiopatrimonial() === $this) {
                $fichaobjetopatrimonial->setSitiopatrimonial(null);
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
            $intervencionconservacion->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeIntervencionconservacion(IntervencionConservacion $intervencionconservacion): self
    {
        if ($this->intervencionconservacion->contains($intervencionconservacion)) {
            $this->intervencionconservacion->removeElement($intervencionconservacion);
            // set the owning side to null (unless already changed)
            if ($intervencionconservacion->getSitiopatrimonial() === $this) {
                $intervencionconservacion->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PortadaSitio[]
     */
    public function getPortadasitio(): Collection
    {
        return $this->portadasitio;
    }

    public function addPortadasitio(PortadaSitio $portadasitio): self
    {
        if (!$this->portadasitio->contains($portadasitio)) {
            $this->portadasitio[] = $portadasitio;
            $portadasitio->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removePortadasitio(PortadaSitio $portadasitio): self
    {
        if ($this->portadasitio->contains($portadasitio)) {
            $this->portadasitio->removeElement($portadasitio);
            // set the owning side to null (unless already changed)
            if ($portadasitio->getSitiopatrimonial() === $this) {
                $portadasitio->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Proyecto[]
     */
    public function getProyecto(): Collection
    {
        return $this->proyecto;
    }

    public function addProyecto(Proyecto $proyecto): self
    {
        if (!$this->proyecto->contains($proyecto)) {
            $this->proyecto[] = $proyecto;
            $proyecto->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeProyecto(Proyecto $proyecto): self
    {
        if ($this->proyecto->contains($proyecto)) {
            $this->proyecto->removeElement($proyecto);
            // set the owning side to null (unless already changed)
            if ($proyecto->getSitiopatrimonial() === $this) {
                $proyecto->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Inventario[]
     */
    public function getInventario(): Collection
    {
        return $this->inventario;
    }

    public function addInventario(Inventario $inventario): self
    {
        if (!$this->inventario->contains($inventario)) {
            $this->inventario[] = $inventario;
            $inventario->setSitiopatrimonial($this);
        }

        return $this;
    }

    public function removeInventario(Inventario $inventario): self
    {
        if ($this->inventario->contains($inventario)) {
            $this->inventario->removeElement($inventario);
            // set the owning side to null (unless already changed)
            if ($inventario->getSitiopatrimonial() === $this) {
                $inventario->setSitiopatrimonial(null);
            }
        }

        return $this;
    }

}