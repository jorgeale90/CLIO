<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\GlobalsInterface;

class AppExtension extends AbstractExtension implements GlobalsInterface
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getGlobals(): array
    {
        $globalVars = [
            'provincia' => $this->em->getRepository('App:Provincia')->findAll(),
            'municipi' => $this->em->getRepository('App:Municipio')->findAll(),
            'nacio' => $this->em->getRepository('App:Nacionalidad')->findAll(),
            'tipositio' => $this->em->getRepository('App:TipoSitio')->findAll(),
            'categoriasitio' => $this->em->getRepository('App:Categoria')->findAll(),
            'paiss' => $this->em->getRepository('App:Pais')->findAll(),
            'tipomaterial' => $this->em->getRepository('App:TipoMaterial')->findAll(),
            'tipoobjeto' => $this->em->getRepository('App:TipoObjeto')->findAll(),
            'integri' => $this->em->getRepository('App:Integridad')->findAll(),
            'tipoproyecto' => $this->em->getRepository('App:TipoProyecto')->findAll(),
            'sitiopatrimonial' => $this->em->getRepository('App:SitioPatrimonial')->findAll(),
            'especialistNew' => $this->em->getRepository('App:Especialista')->findBy(array('new' => true)),
            'especialist' => $this->em->getRepository('App:Especialista')->findAll(),
            'sitiopatrimonialNew' => $this->em->getRepository('App:SitioPatrimonial')->findBy(array('new' => true)),
            'usuario' => $this->em->getRepository('App:User')->findAll(),
            'categoryforo' => $this->em->getRepository('App:Category')->findAll(),
            'nivelescolares' => $this->em->getRepository('App:NivelEscolar')->findAll(),
            'estadoproyecto' => $this->em->getRepository('App:Estado')->findAll(),
            'tipoespecialista' => $this->em->getRepository('App:TipoEspecialista')->findAll(),
            'categoriadocente' => $this->em->getRepository('App:CategoriaDocente')->findAll(),
            'categoriacientifica' => $this->em->getRepository('App:CategoriaCientifica')->findAll(),
            'organis' => $this->em->getRepository('App:Organismo')->findAll(),
            'prof' => $this->em->getRepository('App:Profesion')->findAll(),
            'tipointerven' => $this->em->getRepository('App:TipoIntervencion')->findAll(),
            'causaintv' => $this->em->getRepository('App:CausaIntervencion')->findAll(),
            'intervencion' => $this->em->getRepository('App:Intervencion')->findAll(),
            'proyecto' => $this->em->getRepository('App:Proyecto')->findAll(),
            'tipositionat' => $this->em->getRepository('App:TipoSitioNatural')->findAll(),
            'contextocult' => $this->em->getRepository('App:ContextoCultural')->findAll(),
            'contextogeo' => $this->em->getRepository('App:Contexto')->findAll(),
            'geosistema' => $this->em->getRepository('App:GeoSistema')->findAll(),
            'datacion' => $this->em->getRepository('App:Datacion')->findAll(),
            'zonacostera' => $this->em->getRepository('App:ZonaCostera')->findAll(),
            'region' => $this->em->getRepository('App:Region')->findAll(),
            'propied' => $this->em->getRepository('App:Propiedad')->findAll(),
            'clasifica' => $this->em->getRepository('App:Clasificacion')->findAll(),
            'subtipomat' => $this->em->getRepository('App:SubTipoMaterial')->findAll(),
            'usofunc' => $this->em->getRepository('App:UsoFuncion')->findAll(),
            'categoriaobjet' => $this->em->getRepository('App:CategoriaObjeto')->findAll(),
            'objet' => $this->em->getRepository('App:Objeto')->findAll(),
            'fichaobjetopat' => $this->em->getRepository('App:FichaObjetoPatrimonial')->findAll(),
            'fichaobjetopatNew' => $this->em->getRepository('App:FichaObjetoPatrimonial')->findBy(array('new' => true)),
            'tipointerobje' => $this->em->getRepository('App:TipoIntervencionObjeto')->findAll(),
            'tecnicaaplicad' => $this->em->getRepository('App:TecnicaAplicada')->findAll(),
            'tratamientolaborator' => $this->em->getRepository('App:TratamientoLaboratorio')->findAll(),
            'causaintervencionobjeto' => $this->em->getRepository('App:CausaIntervencionObjeto')->findAll(),
            'tratamientoinsitu' => $this->em->getRepository('App:TratamientoInsitu')->findAll(),
            'intervencionconservacion' => $this->em->getRepository('App:IntervencionConservacion')->findAll(),
            'tipoinventar' => $this->em->getRepository('App:TipoInventario')->findAll(),
            'inventari' => $this->em->getRepository('App:Inventario')->findAll(),
            'settingss'=> $this->em->getRepository('App:Settings')->findAll()
        ];

        return $globalVars;
    }

    public function getName() {
        return 'GlobalExtension';
    }

}