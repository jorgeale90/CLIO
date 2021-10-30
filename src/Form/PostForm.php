<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Category;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

class PostForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $category = $options['cats']->getRepository(Category::class)->findAll();
        
        $builder
            ->add('sharing_icons', CheckboxType::class, [
                'required' => false,
                'data' => false,
                'label' => 'Compartir Post:'
            ])

            ->add('allow_comments', CheckboxType::class, [
                'required' => false,
                'data' => false,
                'label' => 'Permitir Comentarios: '
            ])

            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])

            ->add('subheading', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb3'
                ]
            ])

            ->add('content', CKEditorType::class, array(
                'config_name' => 'main_config2',
            ))

            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => function($category) {
                    return $category->getName();
                },
                'attr' => [
                    'class' => 'form-control'
                ]
            ])

            ->add('tags', TextType::class, [
                'required' => false,
                'mapped' => false,
                'data' => $options['tags'],
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Banana, Apple...'
                ]
            ])

            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/gif',
                            'image/png',
                        ]
                    ])
                ]
            ]) ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'cats' => null,
            'tags' => null
        ]);
    }
}