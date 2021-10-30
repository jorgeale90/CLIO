<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentForm extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('comment', TextareaType::class, [
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Deje su comentario',
                    'rows' => 2
                ]
            ])

            ->add('send', SubmitType::class, [
                'label' => 'Comentar Post',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ]);
    }
}