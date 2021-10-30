<?php

namespace App\Form;

use App\Entity\Post;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostType extends AbstractType
{
    /**
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'topic',
            TextType::class,
            [
                'label' => 'label.topic',
                'required' => true,
                'attr' => ['max_length' => 255],
            ]
        );

        $builder->add('post', CKEditorType::class, array(
            'config_name' => 'main_config2',
        ));

        $builder->add('category', EntityType::class, array(
            'label' => 'País:',
            'placeholder' => 'Seleccione una opción',
            'class' => 'App\Entity\Category',
            'attr' => array('class' => 'form-control js-example-basic-single', 'style' => 'width: 100%;')
        ));

        $builder->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'image_uri' => true,
            ]
        );
    }

    /**
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Post::class]);
    }

    /**
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'post';
    }
}