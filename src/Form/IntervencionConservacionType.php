<?php

namespace App\Form;

use App\Entity\IntervencionConservacion;
use App\Repository\EspecialistaRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IntervencionConservacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cod_intervencion', TextType::class, array(
                'attr' => array('class' => 'validate[required] form-control')
            ))

            ->add('fechainicio', DateTimeType::class, array(
                'required' => false,
                'widget' => 'single_text',
                'html5' => true,
                'attr' => array('class' => 'form-control validate[required]', 'type' => 'datetime-local', 'placeholder' => '1990-04-15')
            ))

            ->add('fechafin', DateTimeType::class, array(
                'required' => false,
                'widget' => 'single_text',
                'html5' => true,
                'attr' => array('class' => 'form-control validate[required]', 'type' => 'datetime-local', 'placeholder' => '1990-04-15')
            ))

            ->add('duracion')

            ->add('objetivo_general', CKEditorType::class, array(
                'config_name' => 'main_config3',
            ))

            ->add('objetivo_especificos', CKEditorType::class, array(
                'config_name' => 'main_config3',
            ))

            ->add('descripcion', CKEditorType::class, array(
                'config_name' => 'main_config3',
            ))

            ->add('proyectogeneral', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('cartaautorizacion', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('sitiopatrimonial', EntityType::class, array(
                'label' => 'Sitio Patrimonial :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\SitioPatrimonial',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('especialista_jefe', EntityType::class, array(
                'label' => 'Especialista Jefe :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Especialista',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('especialistapart', EntityType::class, array(
                'required' => true,
                'multiple' => true,
                'label' => 'Especialistas Participantes:',
                'class' => 'App\Entity\Especialista',
                'query_builder' => function(EspecialistaRepository $em) {
                    return $em->createQueryBuilder('u')
                        ->where('u.state = :variable1')
                        ->andWhere('u.new = :variable2')
                        ->setParameter('variable1', '1')
                        ->setParameter('variable2', '0');
                },
                'attr' => array('class' => 'validate[required] form-control js-example-basic-multiple', 'style' => 'width: 100%;', 'multiple' => 'multiple')
            ))

            ->add('tipointervencionobj', EntityType::class, array(
                'label' => 'Tipo de Intervención del Objeto :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\TipoIntervencionObjeto',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('causaintervencionobj', EntityType::class, array(
                'label' => 'Causa de Intervención del Objeto :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\CausaIntervencionObjeto',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('tratamientoinsitu', EntityType::class, array(
                'label' => 'Tratamiento Insitu :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\TratamientoInsitu',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('tratamientolaboratorio', EntityType::class, array(
                'label' => 'Tratamiento de Laboratorio :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\TratamientoLaboratorio',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('tecnicaaplicada', EntityType::class, array(
                'label' => 'Tecnica Aplicada :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\TecnicaAplicada',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('fichaobjeto', EntityType::class, array(
                'label' => 'Objeto Patrimonial:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\FichaObjetoPatrimonial',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => IntervencionConservacion::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_intervencionconservacion';
    }
}