<?php

namespace App\Form\Type;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentForm extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('post')

            ->add('comment', TextareaType::class, [
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Deje su comentario',
                    'rows' => 2
                ]
            ])

            ->add('state', CheckboxType::class, [
                'required' => false,
                'label' => 'Habilitar Comentarios: '
            ])

            ->add('portada', CheckboxType::class, [
                'required' => false,
                'label' => 'Portada Comentarios: '
            ])
        ;
    }
}