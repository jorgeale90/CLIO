<?php

namespace App\Form;

use App\Entity\Booking;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('beginAt', DateTimeType::class, array(
                'widget' => 'single_text',
                'html5' => true,
                'attr' => array('class' => 'form-control', 'type' => 'datetime-local', 'placeholder' => '1990-04-15')
            ))
            ->add('description', CKEditorType::class, array(
                'config_name' => 'main_config1',
            ))
            ->add('endAt', DateTimeType::class, array(
                'widget' => 'single_text',
                'html5' => true,
                'attr' => array('class' => 'form-control', 'type' => 'datetime-local', 'placeholder' => '1990-04-15')
            ))
            ->add('title')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
