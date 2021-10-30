<?php

namespace App\Form;

use App\Entity\CoordenadasUTM;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoordenadasUTMType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, [
                'required' => false,
                'label' => 'Coordenada UTM:',
                'attr' => array('class' => 'form-control', 'style' => 'width: 100%;')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CoordenadasUTM::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_coordenadasutm';
    }
}