<?php

namespace App\Form;

use App\Entity\CentroLaboral;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CentroLaboralType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('provincia', EntityType::class, array(
                'label' => 'Provincia:',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Provincia',
                'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
            ));

        if (true === $options['editar']) {
            $builder
                ->add('municipio', EntityType::class, array(
                    'label' => 'Municipio:',
                    'placeholder' => 'Seleccione una opción',
                    'class' => 'App\Entity\Municipio',
                    'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;', 'required' => 'true')
                ));
        }
        else
        {
            $builder
                ->add('municipio', EntityType::class, array(
                    'label' => 'Municipio:',
                    'placeholder' => 'Seleccione una opción',
                    'class' => 'App\Entity\Municipio',
                    'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;', 'disabled' => 'true')
                ));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CentroLaboral::class,
            'editar' => false
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_centrolaboral';
    }
}