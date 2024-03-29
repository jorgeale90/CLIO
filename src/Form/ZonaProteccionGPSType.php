<?php

namespace App\Form;

use App\Entity\ZonaProteccionGPS;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZonaProteccionGPSType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('longitudproteccion', null, [
                'required' => false,
                'label' => 'Longitud :',
                'attr' => array('class' => 'form-control', 'style' => 'width: 100%;')
            ])

            ->add('latitudproteccion', null, [
                'required' => false,
                'label' => 'Latitud :',
                'attr' => array('class' => 'form-control', 'style' => 'width: 100%;')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ZonaProteccionGPS::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_zonaprotecciongps';
    }
}