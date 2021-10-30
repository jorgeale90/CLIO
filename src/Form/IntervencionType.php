<?php

namespace App\Form;

use App\Entity\Intervencion;
use App\Repository\EspecialistaRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class IntervencionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cod_intervencion', TextType::class, array(
                'attr' => array('class' => 'validate[required] form-control')
            ))

            ->add('fechainicio', DateTimeType::class, array(
                'widget' => 'single_text',
                'html5' => true,
                'attr' => array('class' => 'form-control validate[required]', 'type' => 'datetime-local', 'placeholder' => '1990-04-15')
            ))

            ->add('fechafin', DateTimeType::class, array(
                'required' => false,
                'widget' => 'single_text',
                'html5' => true,
                'attr' => array('class' => 'form-control', 'type' => 'datetime-local', 'placeholder' => '1990-04-15')
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

            ->add('proyectogeneralFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                ])

            ->add('cartaautorizacionFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
            ])

            ->add('estado', EntityType::class, array(
                'label' => 'Estado:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Estado',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('organismo', EntityType::class, array(
                'label' => 'Organismo:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Organismo',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('causaintervencion', EntityType::class, array(
                'label' => 'Causa de la Intervención:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\CausaIntervencion',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('tipointervencion', EntityType::class, array(
                'label' => 'Tipo de Intervención:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\TipoIntervencion',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('sitiopatrimonial', EntityType::class, array(
                'label' => 'Sitio Patrimonial:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\SitioPatrimonial',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('especialistajefe', EntityType::class, array(
                'label' => 'Especialista Jefe:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Especialista',
                'query_builder' => function(EspecialistaRepository $em) {
                    return $em->createQueryBuilder('u')
                        ->where('u.state = :variable1')
                        ->andWhere('u.new = :variable2')
                        ->setParameter('variable1', '1')
                        ->setParameter('variable2', '0');
                },
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('especialistapart', EntityType::class, array(
                'required' => true,
                'multiple' => true,
                'label' => 'Participantes:',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Intervencion::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_intervencion';
    }
}