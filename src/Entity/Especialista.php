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
use App\Entity\User;

/**
 * @ORM\Table(name="especialista")
 * @ORM\Entity(repositoryClass="App\Repository\EspecialistaRepository")
 * @UniqueEntity(fields={"noReg"}, message="Ya existe este Número de Especialista.")
 * @UniqueEntity(fields={"noId"}, message="Ya existe este Carnet de Identidad.")
 * @Auditable()
 * @Vich\Uploadable
 */

class Especialista
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="bigint", unique=true)
     */
    private $noReg;

    /**
     * @ORM\Column(type="bigint", unique=true)
     */
    private $noId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Municipio", inversedBy="especialistas")
     */
    private $town;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Provincia", inversedBy="especialistas")
     */
    private $provincia;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Nacionalidad", inversedBy="especialistas")
     */
    private $nacionalidad;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=1000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $direccionparticular;

    /**
     * @var integer
     * @ORM\Column(name="movil", type="integer",  nullable=true)
     * @Assert\Regex(pattern="/\w/", match=true, message="Debe contener solo números")
     * @Assert\Length(min=8, max=8, minMessage="Debe contener al menos {{ limit }} números", maxMessage="Debe contener a lo sumo {{ limit }} números")
     */
    private $movil;

    /**
     * @var integer
     * @ORM\Column(name="telefonoparticular", type="integer",  nullable=true)
     * @Assert\Regex(pattern="/\w/", match=true, message="Debe contener solo números")
     * @Assert\Length(min=6, max=10, minMessage="Debe contener al menos {{ limit }} números", maxMessage="Debe contener a lo sumo {{ limit }} números")
     */
    private $telefonoparticular;

    /**
     * @var string
     * @ORM\Column(name="emailparticular", type="string", length=255, nullable=true)
     */
    private $emailparticular;

    /**
     * @var string
     * @ORM\Column(name="cargo", type="string",  nullable=true, length=100)
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú ]*$/",
     *     message="Debe de contener solo letras"
     * )
     * @Assert\Length(min=2, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $cargo;

    /**
     * @var string
     * @ORM\Column(name="centrolaboral", type="string",  nullable=true, length=100)
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú ]*$/",
     *     message="Debe de contener solo letras"
     * )
     * @Assert\Length(min=2, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $centrolaboral;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=1000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $direccionlaboral;

    /**
     * @var integer
     * @ORM\Column(name="telefonolaboral", type="integer",  nullable=true)
     * @Assert\Regex(pattern="/\w/", match=true, message="Debe contener solo números")
     * @Assert\Length(min=6, max=10, minMessage="Debe contener al menos {{ limit }} números", maxMessage="Debe contener a lo sumo {{ limit }} números")
     */
    private $telefonolaboral;

    /**
     * @var string
     * @ORM\Column(name="emaillaboral", type="string", length=255, nullable=true)
     */
    private $emaillaboral;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TipoEspecialista", inversedBy="especialistas")
     */
    private $tipoespecialista;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pais", inversedBy="especialistas")
     */
    private $pais;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NivelEscolar", inversedBy="especialistas")
     */
    private $nivelescolar;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profesion", inversedBy="especialistas")
     */
    private $profesion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategoriaDocente", inversedBy="especialistas")
     */
    private $categoriadocente;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategoriaCientifica", inversedBy="especialistas")
     */
    private $categoriacientifica;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organismo", inversedBy="especialistas")
     */
    private $organismo;

    /**
     * @var string
     * @ORM\Column(name="localidad", type="string",  nullable=true, length=100)
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÑñÓÚáéÍÁÉíóú0-9 ]*$/",
     *     message="Debe de contener solo letras o números"
     * )
     * @Assert\Length(min=2, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $localidad;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $new;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="especialista", cascade={"persist", "remove"})
     */
    private $credentials;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $cv;

    /**
     * @Assert\File(
     *     maxSize = "2048k",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Por favor introducir un PDF valido."
     * )
     * @Vich\UploadableField(mapping="user_cv", fileNameProperty="cv")
     * @var File
     */
    private $cvFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="Intervencion", mappedBy="especialistajefe")
     */
    protected $intervencionjefe;

    /**
     * @ORM\ManyToMany(targetEntity="Intervencion", mappedBy="especialistapart")
     */
    protected $intervencionpart;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Proyecto", mappedBy="especialistaJefe", orphanRemoval=true)
     */
    private $proyectos;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Proyecto", mappedBy="especialistasParticipantes")
     */
    private $proyectosParticipantes;

    /**
     * @ORM\ManyToMany(targetEntity="SitioPatrimonial", mappedBy="especialistasParticipantes")
     */
    private $sitioParticipantes;

    /**
     * @ORM\ManyToMany(targetEntity="FichaObjetoPatrimonial", mappedBy="realizadopor")
     */
    private $fichaobjeto;

    /**
     * @ORM\OneToMany(targetEntity="IntervencionConservacion", mappedBy="especialista_jefe")
     */
    protected $intervencionconservacionjefe;

    /**
     * @ORM\ManyToMany(targetEntity="IntervencionConservacion", mappedBy="especialistapart")
     */
    protected $intervencionconservpart;

    /**
     * @ORM\OneToMany(targetEntity="Inventario", mappedBy="especialistainvejefe")
     */
    protected $inventariojefe;

    /**
     * @ORM\ManyToMany(targetEntity="Inventario", mappedBy="especialistasinvParticipantes")
     */
    private $inventarioParticipantes;

    public function __construct()
    {
        $this->new = true;
        $this->state = false;
        $this->proyectos = new ArrayCollection();
        $this->proyectosParticipantes = new ArrayCollection();
        $this->intervencionjefe = new ArrayCollection();
        $this->intervencionpart = new ArrayCollection();
        $this->sitioParticipantes = new ArrayCollection();
        $this->fichaobjeto = new ArrayCollection();
        $this->intervencionconservpart = new ArrayCollection();
        $this->intervencionconservacionjefe = new ArrayCollection();
        $this->inventariojefe = new ArrayCollection();
        $this->inventarioParticipantes = new ArrayCollection();
    }

    public function __toString(){

        return $this->getCredentials()->getFirstname() . ' ' . $this->getCredentials()->getLastname();

    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $cv
     */
    public function setCvFile(File $cv = null)
    {
        $this->cvFile = $cv;

        if ($cv) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getCvFile()
    {
        return $this->cvFile;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): self
    {
        $this->cv = $cv;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoReg(): ?string
    {
        return $this->noReg;
    }

    public function setNoReg(string $noReg): self
    {
        $this->noReg = $noReg;

        return $this;
    }

    public function getNoId(): ?string
    {
        return $this->noId;
    }

    public function setNoId(string $noId): self
    {
        $this->noId = $noId;

        return $this;
    }

    public function getDireccionparticular(): ?string
    {
        return $this->direccionparticular;
    }

    public function setDireccionparticular(?string $direccionparticular): self
    {
        $this->direccionparticular = $direccionparticular;

        return $this;
    }

    public function getMovil(): ?int
    {
        return $this->movil;
    }

    public function setMovil(?int $movil): self
    {
        $this->movil = $movil;

        return $this;
    }

    public function getTelefonoparticular(): ?int
    {
        return $this->telefonoparticular;
    }

    public function setTelefonoparticular(?int $telefonoparticular): self
    {
        $this->telefonoparticular = $telefonoparticular;

        return $this;
    }

    public function getEmailparticular(): ?string
    {
        return $this->emailparticular;
    }

    public function setEmailparticular(?string $emailparticular): self
    {
        $this->emailparticular = $emailparticular;

        return $this;
    }

    public function getCargo(): ?string
    {
        return $this->cargo;
    }

    public function setCargo(?string $cargo): self
    {
        $this->cargo = $cargo;

        return $this;
    }

    public function getCentrolaboral(): ?string
    {
        return $this->centrolaboral;
    }

    public function setCentrolaboral(?string $centrolaboral): self
    {
        $this->centrolaboral = $centrolaboral;

        return $this;
    }

    public function getDireccionlaboral(): ?string
    {
        return $this->direccionlaboral;
    }

    public function setDireccionlaboral(?string $direccionlaboral): self
    {
        $this->direccionlaboral = $direccionlaboral;

        return $this;
    }

    public function getTelefonolaboral(): ?int
    {
        return $this->telefonolaboral;
    }

    public function setTelefonolaboral(?int $telefonolaboral): self
    {
        $this->telefonolaboral = $telefonolaboral;

        return $this;
    }

    public function getEmaillaboral(): ?string
    {
        return $this->emaillaboral;
    }

    public function setEmaillaboral(?string $emaillaboral): self
    {
        $this->emaillaboral = $emaillaboral;

        return $this;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(?string $localidad): self
    {
        $this->localidad = $localidad;

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

    public function getTown(): ?Municipio
    {
        return $this->town;
    }

    public function setTown(?Municipio $town): self
    {
        $this->town = $town;

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

    public function getNacionalidad(): ?Nacionalidad
    {
        return $this->nacionalidad;
    }

    public function setNacionalidad(?Nacionalidad $nacionalidad): self
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    public function getTipoespecialista(): ?TipoEspecialista
    {
        return $this->tipoespecialista;
    }

    public function setTipoespecialista(?TipoEspecialista $tipoespecialista): self
    {
        $this->tipoespecialista = $tipoespecialista;

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

    public function getNivelescolar(): ?NivelEscolar
    {
        return $this->nivelescolar;
    }

    public function setNivelescolar(?NivelEscolar $nivelescolar): self
    {
        $this->nivelescolar = $nivelescolar;

        return $this;
    }

    public function getProfesion(): ?Profesion
    {
        return $this->profesion;
    }

    public function setProfesion(?Profesion $profesion): self
    {
        $this->profesion = $profesion;

        return $this;
    }

    public function getCategoriadocente(): ?CategoriaDocente
    {
        return $this->categoriadocente;
    }

    public function setCategoriadocente(?CategoriaDocente $categoriadocente): self
    {
        $this->categoriadocente = $categoriadocente;

        return $this;
    }

    public function getCategoriacientifica(): ?CategoriaCientifica
    {
        return $this->categoriacientifica;
    }

    public function setCategoriacientifica(?CategoriaCientifica $categoriacientifica): self
    {
        $this->categoriacientifica = $categoriacientifica;

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

    public function getCredentials(): ?User
    {
        return $this->credentials;
    }

    public function setCredentials(?User $credentials): self
    {
        $this->credentials = $credentials;

        return $this;
    }

    /**
     * @return Collection|Intervencion[]
     */
    public function getIntervencionjefe(): Collection
    {
        return $this->intervencionjefe;
    }

    public function addIntervencionjefe(Intervencion $intervencionjefe): self
    {
        if (!$this->intervencionjefe->contains($intervencionjefe)) {
            $this->intervencionjefe[] = $intervencionjefe;
            $intervencionjefe->setEspecialistajefe($this);
        }

        return $this;
    }

    public function removeIntervencionjefe(Intervencion $intervencionjefe): self
    {
        if ($this->intervencionjefe->contains($intervencionjefe)) {
            $this->intervencionjefe->removeElement($intervencionjefe);
            // set the owning side to null (unless already changed)
            if ($intervencionjefe->getEspecialistajefe() === $this) {
                $intervencionjefe->setEspecialistajefe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Intervencion[]
     */
    public function getIntervencionpart(): Collection
    {
        return $this->intervencionpart;
    }

    public function addIntervencionpart(Intervencion $intervencionpart): self
    {
        if (!$this->intervencionpart->contains($intervencionpart)) {
            $this->intervencionpart[] = $intervencionpart;
            $intervencionpart->addEspecialistapart($this);
        }

        return $this;
    }

    public function removeIntervencionpart(Intervencion $intervencionpart): self
    {
        if ($this->intervencionpart->contains($intervencionpart)) {
            $this->intervencionpart->removeElement($intervencionpart);
            $intervencionpart->removeEspecialistapart($this);
        }

        return $this;
    }

    /**
     * @return Collection|Proyecto[]
     */
    public function getProyectos(): Collection
    {
        return $this->proyectos;
    }

    public function addProyecto(Proyecto $proyecto): self
    {
        if (!$this->proyectos->contains($proyecto)) {
            $this->proyectos[] = $proyecto;
            $proyecto->setEspecialistaJefe($this);
        }

        return $this;
    }

    public function removeProyecto(Proyecto $proyecto): self
    {
        if ($this->proyectos->contains($proyecto)) {
            $this->proyectos->removeElement($proyecto);
            // set the owning side to null (unless already changed)
            if ($proyecto->getEspecialistaJefe() === $this) {
                $proyecto->setEspecialistaJefe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Proyecto[]
     */
    public function getProyectosParticipantes(): Collection
    {
        return $this->proyectosParticipantes;
    }

    public function addProyectosParticipante(Proyecto $proyectosParticipante): self
    {
        if (!$this->proyectosParticipantes->contains($proyectosParticipante)) {
            $this->proyectosParticipantes[] = $proyectosParticipante;
            $proyectosParticipante->addEspecialistasParticipante($this);
        }

        return $this;
    }

    public function removeProyectosParticipante(Proyecto $proyectosParticipante): self
    {
        if ($this->proyectosParticipantes->contains($proyectosParticipante)) {
            $this->proyectosParticipantes->removeElement($proyectosParticipante);
            $proyectosParticipante->removeEspecialistasParticipante($this);
        }

        return $this;
    }

    /**
     * @return Collection|SitioPatrimonial[]
     */
    public function getSitioParticipantes(): Collection
    {
        return $this->sitioParticipantes;
    }

    public function addSitioParticipante(SitioPatrimonial $sitioParticipante): self
    {
        if (!$this->sitioParticipantes->contains($sitioParticipante)) {
            $this->sitioParticipantes[] = $sitioParticipante;
            $sitioParticipante->addEspecialistasParticipante($this);
        }

        return $this;
    }

    public function removeSitioParticipante(SitioPatrimonial $sitioParticipante): self
    {
        if ($this->sitioParticipantes->contains($sitioParticipante)) {
            $this->sitioParticipantes->removeElement($sitioParticipante);
            $sitioParticipante->removeEspecialistasParticipante($this);
        }

        return $this;
    }

    /**
     * @return Collection|FichaObjetoPatrimonial[]
     */
    public function getFichaobjeto(): Collection
    {
        return $this->fichaobjeto;
    }

    public function addFichaobjeto(FichaObjetoPatrimonial $fichaobjeto): self
    {
        if (!$this->fichaobjeto->contains($fichaobjeto)) {
            $this->fichaobjeto[] = $fichaobjeto;
            $fichaobjeto->addRealizadopor($this);
        }

        return $this;
    }

    public function removeFichaobjeto(FichaObjetoPatrimonial $fichaobjeto): self
    {
        if ($this->fichaobjeto->contains($fichaobjeto)) {
            $this->fichaobjeto->removeElement($fichaobjeto);
            $fichaobjeto->removeRealizadopor($this);
        }

        return $this;
    }

    /**
     * @return Collection|IntervencionConservacion[]
     */
    public function getIntervencionconservpart(): Collection
    {
        return $this->intervencionconservpart;
    }

    public function addIntervencionconservpart(IntervencionConservacion $intervencionconservpart): self
    {
        if (!$this->intervencionconservpart->contains($intervencionconservpart)) {
            $this->intervencionconservpart[] = $intervencionconservpart;
            $intervencionconservpart->addEspecialistapart($this);
        }

        return $this;
    }

    public function removeIntervencionconservpart(IntervencionConservacion $intervencionconservpart): self
    {
        if ($this->intervencionconservpart->contains($intervencionconservpart)) {
            $this->intervencionconservpart->removeElement($intervencionconservpart);
            $intervencionconservpart->removeEspecialistapart($this);
        }

        return $this;
    }

    /**
     * @return Collection|IntervencionConservacion[]
     */
    public function getIntervencionconservacionjefe(): Collection
    {
        return $this->intervencionconservacionjefe;
    }

    public function addIntervencionconservacionjefe(IntervencionConservacion $intervencionconservacionjefe): self
    {
        if (!$this->intervencionconservacionjefe->contains($intervencionconservacionjefe)) {
            $this->intervencionconservacionjefe[] = $intervencionconservacionjefe;
            $intervencionconservacionjefe->setEspecialistaJefe($this);
        }

        return $this;
    }

    public function removeIntervencionconservacionjefe(IntervencionConservacion $intervencionconservacionjefe): self
    {
        if ($this->intervencionconservacionjefe->contains($intervencionconservacionjefe)) {
            $this->intervencionconservacionjefe->removeElement($intervencionconservacionjefe);
            // set the owning side to null (unless already changed)
            if ($intervencionconservacionjefe->getEspecialistaJefe() === $this) {
                $intervencionconservacionjefe->setEspecialistaJefe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Inventario[]
     */
    public function getInventariojefe(): Collection
    {
        return $this->inventariojefe;
    }

    public function addInventariojefe(Inventario $inventariojefe): self
    {
        if (!$this->inventariojefe->contains($inventariojefe)) {
            $this->inventariojefe[] = $inventariojefe;
            $inventariojefe->setEspecialistainvejefe($this);
        }

        return $this;
    }

    public function removeInventariojefe(Inventario $inventariojefe): self
    {
        if ($this->inventariojefe->contains($inventariojefe)) {
            $this->inventariojefe->removeElement($inventariojefe);
            // set the owning side to null (unless already changed)
            if ($inventariojefe->getEspecialistainvejefe() === $this) {
                $inventariojefe->setEspecialistainvejefe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Inventario[]
     */
    public function getInventarioParticipantes(): Collection
    {
        return $this->inventarioParticipantes;
    }

    public function addInventarioParticipante(Inventario $inventarioParticipante): self
    {
        if (!$this->inventarioParticipantes->contains($inventarioParticipante)) {
            $this->inventarioParticipantes[] = $inventarioParticipante;
            $inventarioParticipante->addEspecialistasinvParticipante($this);
        }

        return $this;
    }

    public function removeInventarioParticipante(Inventario $inventarioParticipante): self
    {
        if ($this->inventarioParticipantes->contains($inventarioParticipante)) {
            $this->inventarioParticipantes->removeElement($inventarioParticipante);
            $inventarioParticipante->removeEspecialistasinvParticipante($this);
        }

        return $this;
    }

}