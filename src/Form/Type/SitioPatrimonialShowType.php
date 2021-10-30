<?php

namespace App\Form\Type;

use App\Entity\Especialista;
use App\Entity\SitioPatrimonial;
use App\Form\CoordenadasGPSType;
use App\Form\CoordenadasUTMType;
use App\Form\ZonaInsertidumbreGPSType;
use App\Form\ZonaObjetoGPSType;
use App\Form\ZonaPatrimonialGPSType;
use App\Form\ZonaProteccionGPSType;
use App\Repository\EspecialistaRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class SitioPatrimonialShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo')

            ->add('ref_expediente')

            ->add('consejopopular')

            ->add('areaobjeto')

            ->add('areapatrimonial')

            ->add('areaproteccion')

            ->add('areainsertidumbre')

            ->add('maxaltura')

            ->add('datacionrelaticadesde', DateTimeType::class, array(
                'widget' => 'single_text',
                'html5' => true,
                'attr' => array('class' => 'form-control', 'type' => 'datetime-local', 'placeholder' => '1990-04-15', 'required' => 'false')
            ))

            ->add('datacionrelaticahasta', DateTimeType::class, array(
                'widget' => 'single_text',
                'html5' => true,
                'attr' => array('class' => 'form-control', 'type' => 'datetime-local', 'placeholder' => '1990-04-15', 'required' => 'false')
            ))

            ->add('datacionabsoluta', DateTimeType::class, array(
                'widget' => 'single_text',
                'html5' => true,
                'attr' => array('class' => 'form-control', 'type' => 'datetime-local', 'placeholder' => '1990-04-15', 'required' => 'false')
            ))

            ->add('fecharegistro', DateTimeType::class, array(
                'required' => false,
                'widget' => 'single_text',
                'html5' => true,
                'attr' => array('class' => 'form-control', 'type' => 'datetime-local', 'placeholder' => '1990-04-15', 'required' => 'false')
            ))

            ->add('fechainscripcion', DateTimeType::class, array(
                'required' => false,
                'widget' => 'single_text',
                'html5' => true,
                'attr' => array('class' => 'form-control', 'type' => 'datetime-local', 'placeholder' => '1990-04-15', 'required' => 'false')
            ))

            ->add('nombre')

            ->add('otrosNombre')

            ->add('keyword')

            ->add('categoria', EntityType::class, array(
                'label' => 'Categoría:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Categoria',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('tipositio', EntityType::class, array(
                'label' => 'Tipo de Sitio Cultural:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\TipoSitio',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('tipositionatural', EntityType::class, array(
                'label' => 'Tipo de Sitio Natural:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\TipoSitioNatural',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('propiedad', EntityType::class, array(
                'label' => 'Propiedad:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Propiedad',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('pais', EntityType::class, array(
                'label' => 'País:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Pais',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('localidad')

            ->add('descripcion_general')

            ->add('caracteristicas_generales')

            ->add('demarcacion_visual')

            ->add('coordenadasgps', CollectionType::class, [
                'entry_type' => CoordenadasGPSType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true
            ])

            ->add('coordenadasutm', CollectionType::class, [
                'entry_type' => CoordenadasUTMType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true
            ])

            ->add('especialistasParticipantes', EntityType::class, array(
                'label' => 'Participantes:',
                'class' => Especialista::class,
                'multiple' => true,
                'query_builder' => function(EspecialistaRepository $em) {
                    return $em->createQueryBuilder('u')
                        ->where('u.state = :variable1')
                        ->andWhere('u.new = :variable2')
                        ->setParameter('variable1', '1')
                        ->setParameter('variable2', '0');
                },
                'attr' => array('class' => 'validate[required] form-control js-example-basic-multiple', 'style' => 'width: 100%;', 'multiple' => 'multiple')
            ))

            ->add('enfilaciones')

            ->add('croquis', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('planimetria', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('fotogrametria', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('fotografias', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('video', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('modelo3d', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('bibliografia', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('publicaciones', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('referenciaweb', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('contexto', EntityType::class, array(
                'label' => 'Contexto:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Contexto',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('zonacostera', EntityType::class, array(
                'label' => 'Zona Costera:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\ZonaCostera',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('region', EntityType::class, array(
                'label' => 'Region:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Region',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('geosistema', EntityType::class, array(
                'label' => 'GeoSistema:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\GeoSistema',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('contextocultural', EntityType::class, array(
                'label' => 'Contexto Cultural :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\ContextoCultural',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('datacion', EntityType::class, array(
                'label' => 'Datacion :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Datacion',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('fechaconocimiento', DateTimeType::class, array(
                'required' => false,
                'widget' => 'single_text',
                'html5' => true,
                'attr' => array('class' => 'form-control', 'type' => 'datetime-local', 'placeholder' => '1990-04-15', 'required' => 'false')
            ))

            ->add('zonaobjetogps', CollectionType::class, [
                'entry_type' => ZonaObjetoGPSType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true
            ])

            ->add('zonapatrimonialgps', CollectionType::class, [
                'entry_type' => ZonaPatrimonialGPSType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true
            ])

            ->add('zonaprotecciongps', CollectionType::class, [
                'entry_type' => ZonaProteccionGPSType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true
            ])

            ->add('zonainsertidumbregps', CollectionType::class, [
                'entry_type' => ZonaInsertidumbreGPSType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true
            ])

            ->add('tipo_construccion')

            ->add('hecho_historico')

            ->add('descripcion_tecnica')

            ->add('tipo_arquitectura')

            ->add('referencia_documental')

            ->add('antecedentes_historicos')

            ->add('cant_inventario')

            ->add('cant_intervenciones_const')

            ->add('cant_intervenciones_conserv')

            ->add('cant_objetos_patrim')

            ->add('promedio_visitas_diaria')

            ->add('promedio_visitas_mensuales')

            ->add('promedio_visitas_anuales')

            ->add('promedio_recaudacion')

            ->add('recibe_visita')

            ->add('nivel_visitas', ChoiceType::class, [
                'required' => false,
                'placeholder' => 'Seleccione una opción',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;', 'required' => 'false'),
                'choices'  => [
                    'Alto' => 'Alto',
                    'Medio' => 'Medio',
                    'Bajo' => 'Bajo',
                ],
            ])

            ->add('cerrado_publico')

            ->add('expoliado')

            ->add('dannado')

            ->add('inventarios')

            ->add('nivel_antropizacion', ChoiceType::class, [
                'required' => false,
                'placeholder' => 'Seleccione una opción',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;', 'required' => 'false'),
                'choices'  => [
                    'Alta' => 'Alta',
                    'Media' => 'Media',
                    'Baja' => 'Baja',
                ],
            ])

            ->add('estado_conservacion', ChoiceType::class, [
                'required' => false,
                'placeholder' => 'Seleccione una opción',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;', 'required' => 'false'),
                'choices'  => [
                    'Buena' => 'Buena',
                    'Regular' => 'Regular',
                    'Mala' => 'Mala',
                ],
            ])

            ->add('degradacion')

            ->add('plan_manejo')

            ->add('declarado')

            ->add('riesgos_potenciales')

            ->add('medidas_proteccion')

            ->add('medidas_seguridad')

            ->add('intervencion_construc')

            ->add('intervencion_arqueol')

            ->add('intervencion_conserv')

            ->add('estado_conserv')

            ->add('antropizacion')

            ->add('causa_degradacion')

            ->add('propuesta_actuacion')

            ->add('fecha_declaracion', DateTimeType::class, array(
                'required' => false,
                'widget' => 'single_text',
                'html5' => true,
                'attr' => array('class' => 'form-control', 'type' => 'datetime-local', 'placeholder' => '1990-04-15', 'required' => 'false')
            ))

            ->add('no_expe_declaracion')

            ->add('plan', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('declaracion', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('municipio', EntityType::class, array(
                'label' => 'Municipio:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Municipio',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;', 'required' => 'true')
            ))

            ->add('provincia', EntityType::class, array(
                'label' => 'Provincia:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Provincia',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;', 'required' => 'true')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SitioPatrimonial::class
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_sitiopatrimonial';
    }
}