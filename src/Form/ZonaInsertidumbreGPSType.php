<?php

namespace App\Form;

use App\Entity\ZonaInsertidumbreGPS;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZonaInsertidumbreGPSType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('longitudinsert', null, [
                'required' => false,
                'label' => 'Longitud :',
                'attr' => array('class' => 'form-control', 'style' => 'width: 100%;')
            ])

            ->add('latitudinsert', null, [
                'required' => false,
                'label' => 'Latitud :',
                'attr' => array('class' => 'form-control', 'style' => 'width: 100%;')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ZonaInsertidumbreGPS::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_zonainsertidumbregps';
    }
}