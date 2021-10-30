<?php

namespace App\Form;

use App\Entity\Settings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('page_name')

            ->add('tagline')

            ->add('email')

            ->add('phone_1')

            ->add('phone_2')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Settings::class
        ]);
    }
}
