<?php

namespace App\Form;

use App\Entity\Especialista;
use App\Entity\FichaObjetoPatrimonial;
use App\Entity\Inventario;
use App\Repository\EspecialistaRepository;
use App\Repository\FichaObjetoPatrimonialRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cod_inventario', TextType::class, array(
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

            ->add('estado', ChoiceType::class, [
                'required' => true,
                'placeholder' => 'Seleccione una opción',
                'attr' => array('class' => 'form-control validate[required] js-example-basic-single', 'style' => 'width: 100%;'),
                'choices' => [
                    'Planificación' => 'Planificación',
                    'En Ejecución' => 'En Ejecución',
                    'Completado' => 'Completado',
                    'Cancelado' => 'Cancelado'
                ],
            ])

            ->add('especialistainvejefe', EntityType::class, array(
                'label' => 'Especialista Jefe:',
                'placeholder' => 'Seleccione el Especialista Jefe',
                'class' => Especialista::class,
                'query_builder' => function (EspecialistaRepository $em) {
                    return $em->createQueryBuilder('u')
                        ->where('u.state = :variable1')
                        ->andWhere('u.new = :variable2')
                        ->setParameter('variable1', '1')
                        ->setParameter('variable2', '0');
                },
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('especialistasinvParticipantes', EntityType::class, array(
                'label' => 'Participantes:',
                'placeholder' => 'Seleccione los Especialistas Participantes',
                'class' => Especialista::class,
                'multiple' => true,
                'query_builder' => function (EspecialistaRepository $em) {
                    return $em->createQueryBuilder('u')
                        ->where('u.state = :variable1')
                        ->andWhere('u.new = :variable2')
                        ->setParameter('variable1', '1')
                        ->setParameter('variable2', '0');
                },
                'attr' => array('class' => 'validate[required] form-control js-example-basic-multiple', 'style' => 'width: 100%;', 'multiple' => 'multiple')
            ))

            ->add('sitiopatrimonial', EntityType::class, array(
                'label' => 'Sitio Patrimonial :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\SitioPatrimonial',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('objetospresentes', EntityType::class, array(
                'required' => true,
                'label' => 'Objetos Presentes :',
                'class' => FichaObjetoPatrimonial::class,
                'multiple' => true,
                'query_builder' => function (FichaObjetoPatrimonialRepository $em) {
                    return $em->createQueryBuilder('u')
                        ->where('u.state = :variable1')
                        ->andWhere('u.new = :variable2')
                        ->setParameter('variable1', '1')
                        ->setParameter('variable2', '0');
                },
                'attr' => array('class' => 'validate[required] form-control js-example-basic-multiple', 'style' => 'width: 100%;', 'multiple' => 'multiple')
            ))

            ->add('tipoinventario', EntityType::class, array(
                'label' => 'Tipo Inventario :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\TipoInventario',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('autorizacion', ChoiceType::class, [
                'required' => false,
                'placeholder' => 'Seleccione una opción',
                'attr' => array('class' => 'form-control js-example-basic-single', 'style' => 'width: 100%;'),
                'choices' => [
                    'Autorizado' => 'Autorizado',
                    'No Autorizado' => 'No Autorizado',
                    'Pendiente' => 'Pendiente'
                ],
            ])

            ->add('faltantes')

            ->add('objetosfaltantes', EntityType::class, array(
                'required' => false,
                'label' => 'Objetos Faltantes :',
                'class' => FichaObjetoPatrimonial::class,
                'multiple' => true,
                'query_builder' => function (FichaObjetoPatrimonialRepository $em) {
                    return $em->createQueryBuilder('u')
                        ->where('u.state = :variable1')
                        ->andWhere('u.new = :variable2')
                        ->setParameter('variable1', '1')
                        ->setParameter('variable2', '0');
                },
                'attr' => array('class' => 'form-control js-example-basic-multiple', 'style' => 'width: 100%;', 'multiple' => 'multiple')
            ))

            ->add('descripcion_faltantes', CKEditorType::class, array(
                'config_name' => 'main_config3',
            ))

            ->add('causas_faltantes', CKEditorType::class, array(
                'config_name' => 'main_config3',
            ))

            ->add('ordeninventario', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('cartaautorizacioninventario', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inventario::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_inventario';
    }
}