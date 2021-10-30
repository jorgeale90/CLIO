<?php

namespace App\Form;

use App\Entity\Especialista;
use App\Entity\Estado;
use App\Entity\Proyecto;
use App\Entity\TipoProyecto;
use App\Repository\EspecialistaRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ProyectoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codProyecto', TextType::class, array(
                'attr' => array('class' => 'validate[required]')
            ))

            ->add('nombre', TextType::class, array(
                'attr' => array('class' => 'validate[required]')
            ))

            ->add('fechaInicio', DateTimeType::class, array(
                'widget' => 'single_text',
                'html5' => true,
                'attr' => array('class' => 'form-control validate[required]', 'type' => 'datetime-local', 'placeholder' => '1990-04-15')
            ))

            ->add('fechaFin', DateTimeType::class, array(
                'widget' => 'single_text',
                'required' => false,
                'html5' => true,
                'attr' => array('class' => 'form-control validate[required]', 'type' => 'datetime-local', 'placeholder' => '1990-04-15')
            ))

            ->add('duracion')

            ->add('objGeneral', CKEditorType::class, array(
                'config_name' => 'main_config3',
            ))

            ->add('objEspecificos', CKEditorType::class, array(
                'config_name' => 'main_config3',
            ))

            ->add('proyGeneralFile', VichFileType::class, array(
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
            ))
            ->add('cartaAutorizacionFile', VichFileType::class, array(
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
            ))

            ->add('especialistaJefe', EntityType::class, array(
                'label' => 'Especialista Jefe:',
                'placeholder' => 'Seleccione una opción',
                'class' => Especialista::class,
                'query_builder' => function(EspecialistaRepository $em) {
                    return $em->createQueryBuilder('u')
                        ->where('u.state = :variable1')
                        ->andWhere('u.new = :variable2')
                        ->setParameter('variable1', '1')
                        ->setParameter('variable2', '0');
                },
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('estado', EntityType::class, array(
                'placeholder' => 'Seleccione una opción',
                'class' => Estado::class,
                'attr' => array(
                    'class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

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

            ->add('tipoProyecto', EntityType::class, array(
                'placeholder' => 'Seleccione una opción',
                'class' => TipoProyecto::class,
                'attr' => array(
                    'class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('sitiopatrimonial', EntityType::class, array(
                'label' => 'Sitio Patrimonial:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\SitioPatrimonial',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Proyecto::class,
        ]);
    }
}
