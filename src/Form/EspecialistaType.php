<?php

namespace App\Form;

use App\Entity\Especialista;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EspecialistaType extends AbstractType
{
    public $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('noReg', NumberType::class, array(
                'attr' => array('class' => 'form-control validate[required]')
            ))

            ->add('noId', NumberType::class, array(
                'attr' => array('class' => 'form-control validate[required, maxSize[11], minSize[11]')
            ))

            ->add('credentials', UserType::class, array(
                'label_attr' => array('style' => 'display: none')
            ));

        if (true === $options['editar'] and $this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            $builder
                ->add('provincia', EntityType::class, array(
                    'required' => true,
                    'label' => 'Provincia:',
                    'placeholder' => 'Seleccione una opción',
                    'class' => 'App\Entity\Provincia',
                    'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
                ));

        } elseif ($this->security->isGranted('IS_AUTHENTICATED_FULLY') and false === $options['editar']) {
            $builder
                ->add('provincia', EntityType::class, array(
                    'required' => true,
                    'label' => 'Provincia:',
                    'placeholder' => 'Seleccione una opción',
                    'class' => 'App\Entity\Provincia',
                    'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
                ));
        }

        if (true === $options['editar'] and $this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            $builder
                ->add('town', EntityType::class, array(
                    'required' => true,
                    'label' => 'Municipio:',
                    'placeholder' => 'Seleccione una opción',
                    'class' => 'App\Entity\Municipio',
                    'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
                ));

        } elseif ($this->security->isGranted('IS_AUTHENTICATED_FULLY') and false === $options['editar']) {
            $builder
                ->add('town', EntityType::class, array(
                    'required' => true,
                    'label' => 'Municipio:',
                    'placeholder' => 'Seleccione una opción',
                    'class' => 'App\Entity\Municipio',
                    'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
                ));
        }

        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            $builder
                ->add('pais', EntityType::class, array(
                    'required' => true,
                    'label' => 'País:',
                    'placeholder' => 'Seleccione el País',
                    'class' => 'App\Entity\Pais',
                    'attr' => array('class' => 'validate[required] form-control js-example-basic-single', 'style' => 'width: 100%;')
                ))

                ->add('nacionalidad', EntityType::class, array(
                    'required' => false,
                    'label' => 'Nacionalidad:',
                    'placeholder' => 'Seleccione una Nacionalidad',
                    'class' => 'App\Entity\Nacionalidad',
                    'attr' => array('class' => 'form-control js-example-basic-single', 'style' => 'width: 100%;')
                ))

                ->add('direccionparticular', CKEditorType::class, array(
                    'config_name' => 'main_config3',
                ))
                ->add('localidad', TextType::class, array(
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('movil', NumberType::class, array(
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('telefonoparticular', NumberType::class, array(
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('emailparticular', TextType::class, array(
                    'required' => false,
                    'attr' => array('class' => 'form-control validate[custom[email]]')
                ))
                ->add('cargo', TextType::class, array(
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('direccionlaboral', CKEditorType::class, array(
                    'config_name' => 'main_config3',
                    'attr' => array('class' => 'validate[required]')
                ))
                ->add('telefonolaboral', NumberType::class, array(
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('emaillaboral', TextType::class, array(
                    'required' => false,
                    'attr' => array('class' => 'form-control validate[custom[email]]')
                ))
                ->add('tipoespecialista', EntityType::class, array(
                    'required' => false,
                    'label' => 'Tipo de Especialista:',
                    'placeholder' => 'Seleccione un Tipo de Especialista',
                    'class' => 'App\Entity\TipoEspecialista',
                    'attr' => array('class' => 'form-control js-example-basic-single', 'style' => 'width: 100%;')
                ))
                ->add('centrolaboral', TextType::class, array(
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('nivelescolar', EntityType::class, array(
                    'required' => false,
                    'label' => 'Nivel Escolar:',
                    'placeholder' => 'Seleccione un Nivel Escolar',
                    'class' => 'App\Entity\NivelEscolar',
                    'attr' => array('class' => 'form-control js-example-basic-single', 'style' => 'width: 100%;')
                ))
                ->add('categoriadocente', EntityType::class, array(
                    'required' => false,
                    'label' => 'Categoría Docente:',
                    'placeholder' => 'Seleccione una Categoría Docente',
                    'class' => 'App\Entity\CategoriaDocente',
                    'attr' => array('class' => 'form-control js-example-basic-single', 'style' => 'width: 100%;')
                ))
                ->add('categoriacientifica', EntityType::class, array(
                    'required' => false,
                    'label' => 'Categoría Científica:',
                    'placeholder' => 'Seleccione una Categoría Científica',
                    'class' => 'App\Entity\CategoriaCientifica',
                    'attr' => array('class' => 'form-control js-example-basic-single', 'style' => 'width: 100%;')
                ))
                ->add('profesion', EntityType::class, array(
                    'required' => false,
                    'label' => 'Profesión:',
                    'placeholder' => 'Seleccione una Profesión',
                    'class' => 'App\Entity\Profesion',
                    'attr' => array('class' => 'form-control js-example-basic-single', 'style' => 'width: 100%;')
                ))
                ->add('organismo', EntityType::class, array(
                    'required' => false,
                    'label' => 'Organismo:',
                    'placeholder' => 'Seleccione un Organismo',
                    'class' => 'App\Entity\Organismo',
                    'attr' => array('class' => 'form-control js-example-basic-single', 'style' => 'width: 100%;')
                ))
                ->add('cvFile', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => true,
                    'download_uri' => true,]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Especialista::class,
            'editar' => false
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_especialista';
    }
}
