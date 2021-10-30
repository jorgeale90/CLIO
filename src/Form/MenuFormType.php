<?php

namespace App\Form;

use App\Entity\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MenuFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $category = $options['em']->getRepository(\App\Entity\Category::class)->findAll();
        
        $builder
            ->add('category', EntityType::class, [
                'class' => \App\Entity\Category::class,
                'label' => 'Categoría * :',
                'placeholder' => 'Seleccione una opción',
                'attr' => [
                    'class' => 'form-control js-example-basic-single', 'style' => 'width: 100%;'
                ],
                'choice_label' => function($category) {
                    return $category->getName();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
            'em' => null
        ]);
    }
}
