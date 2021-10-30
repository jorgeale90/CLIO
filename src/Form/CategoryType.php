<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

/**
 * Class CategoryType.
 */
class CategoryType extends AbstractType
{
    /**
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
            'name',
            TextType::class,
                [
                    'label' => 'Categoría',
                    'required' => true,
                    'attr' => ['max_length' => 64],
                ]
            )

            ->add('description', CKEditorType::class, array(
                'config_name' => 'main_config1',
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Category::class]);
    }

    /**
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'category';
    }
}