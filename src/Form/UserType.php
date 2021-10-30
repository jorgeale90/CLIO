<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array('required' => false,'attr' => array('placeholder' => 'Nombre(s)', 'class' => 'input100')))
            ->add('lastname', TextType::class, array('required' => false,'attr' => array('placeholder' => 'Apellidos', 'class' => 'input100')))
            ->add('email', EmailType::class, array('required' => false,'attr' => array('placeholder' => 'Correo Electrónico', 'class' => 'input100')))
            ->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Por favor introduce la contraseña',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Tu contraseña debe tener al menos {{ limit }} caracteres',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                    'invalid_message' => 'Debe de coincidir las contraseña',
                    'first_options' => array('attr' => array('class' => 'input100', 'placeholder' => 'Contraseña')),
                    'second_options' => array('attr' => array('class' => 'input100', 'placeholder' => 'Repita la contraseña')),
                    'required' => false)
            );
            if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
                $builder
                    ->add('imageFile', VichImageType::class, [
                        'required' => false,
                        'allow_delete' => true,
                        'download_uri' => true,
                        'image_uri' => true,
                        'constraints' => [
                            new File([
                                'maxSize' => '5M',
                                'mimeTypes' => [
                                    'image/jpeg',
                                    'image/gif',
                                    'image/png',
                                ]
                            ])
                        ]
                    ]);
            }
        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            switch ($this->security->getUser()->getRoles()[0]) {
                case 'ROLE_ADMIN':
                    $builder
                        ->add('roles', ChoiceType::class, array(
                            'required' => false,
                            'placeholder' => 'Seleccione un Rol',
                            'choices' => [
                                'Administrador' => 'ROLE_ADMIN',
                                'Moderador' => 'ROLE_MODERADOR',
                                'Especialista' => 'ROLE_ESPECIALISTA'
                            ],
//                            'multiple' => true
                        ))
                    ;
                    break;
                case 'ROLE_MODERADOR':
                    $builder
                        ->add('roles', ChoiceType::class, array(
                            'required' => false,
                            'placeholder' => 'Seleccione un Rol',
                            'choices' => [
                                'Moderador' => 'ROLE_MODERADOR',
                                'Especialista' => 'ROLE_ESPECIALISTA'
                            ],
//                            'multiple' => true
                        ))
                    ;
                    break;
            }
            $builder->get('roles')->addModelTransformer(new CallbackTransformer(
                function ($rolesAsArray){
                    return $rolesAsArray[0];
                },
                function ($rolesAsString){
                    return [$rolesAsString];
                }
            ));
        } elseif (!$this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            $builder
                ->add('agreeTerms', CheckboxType::class, [
                    'mapped' => false,
                    'constraints' => [
                        new IsTrue([
                            'message' => 'Usted acepta los terminos de uso.',
                        ]),
                    ],
                ])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_usuario';
    }
}
