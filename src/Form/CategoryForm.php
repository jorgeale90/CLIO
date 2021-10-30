<?php

namespace App\Form;

use App\Entity\Category;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoryForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('name', TextType::class, [
                'label' => 'Categoría',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])

            ->add('exerpt', CKEditorType::class, array(
                'config_name' => 'main_config3',
            ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Category::class
        ]);
    }

}