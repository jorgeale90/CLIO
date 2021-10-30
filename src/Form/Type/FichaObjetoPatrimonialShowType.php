<?php

namespace App\Form\Type;

use App\Entity\FichaObjetoPatrimonial;
use App\Entity\Especialista;
use App\Repository\EspecialistaRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FichaObjetoPatrimonialShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigoobjeto', TextType::class, array(
                'attr' => array('class' => 'validate[required] form-control')
            ))

            ->add('keyword')

            ->add('nombreobjeto', TextType::class, array(
                'attr' => array('class' => 'validate[required] form-control')
            ))

            ->add('otronombreobjeto')

            ->add('descripcion_tecnica')

            ->add('descripcion_visual')

            ->add('marcas_visibles')

            ->add('autor')

            ->add('realizadopor', EntityType::class, array(
                'label' => 'Realizado por:',
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

            ->add('fecharealizacion', DateTimeType::class, array(
                'required' => false,
                'widget' => 'single_text',
                'html5' => true,
                'attr' => array('class' => 'form-control validate[required]', 'type' => 'datetime-local', 'placeholder' => '1990-04-15')
            ))

            ->add('fuepropiedad')

            ->add('pais', EntityType::class, array(
                'label' => 'País:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Pais',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('lugar_procedencia')

            ->add('propiedad_actual')

            ->add('hecho_historico_relacionado')

            ->add('altura')

            ->add('ancho')

            ->add('largo')

            ->add('grosor')

            ->add('diametro')

            ->add('peso')

            ->add('clasificacion', EntityType::class, array(
                'label' => 'Clasificación :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Clasificacion',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('tipomaterial', EntityType::class, array(
                'label' => 'Tipo de Material :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\TipoMaterial',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('subtipomaterial', EntityType::class, array(
                'label' => 'SubTipo de Material :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\SubTipoMaterial',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('categoriaobjeto', EntityType::class, array(
                'label' => 'Categoría del Objeto :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\CategoriaObjeto',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('usofuncion', EntityType::class, array(
                'label' => 'Uso - Función :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\UsoFuncion',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('datacion', EntityType::class, array(
                'label' => 'Datación :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Datacion',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('integridad', EntityType::class, array(
                'label' => 'Integridad :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Integridad',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ))

            ->add('estado_conservacion', ChoiceType::class, [
                'required' => false,
                'placeholder' => 'Seleccione una opción',
                'attr' => array('class' => 'form-control js-example-basic-single', 'style' => 'width: 100%;'),
                'choices' => [
                    'Buena' => 'Buena',
                    'Regular' => 'Regular',
                    'Mala' => 'Mala',
                ],
            ])

            ->add('expuesto_publico')

            ->add('lugares_exposicion')

            ->add('fotografiaobjeto', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('dibujoobjeto', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('fotogrametriaobjeto', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('modelo3dobjeto', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('bibliografiaobjeto', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('publicacionesobjeto', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('referenciawebobjeto', FileType::class, [
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
            'data_class' => FichaObjetoPatrimonial::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_fichaobjetopatrimonial';
    }
}