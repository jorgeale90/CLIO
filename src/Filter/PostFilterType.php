<?php
// ItemFilterType.php
namespace App\Filter;

use App\Entity\Category;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

class PostFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', Filters\TextFilterType::class);

        $builder->add('subheading', Filters\TextFilterType::class);

        $builder->add('user', Filters\EntityFilterType::class, [
            'data_class' => User::class,
            'class' => User::class,
            'placeholder' => 'Seleccione una opción',
            'label' => 'Usuario del Post :',
            'attr' => array('class' => 'form-control js-example-basic-single')
        ]);

        $builder->add('category', Filters\EntityFilterType::class, [
            'data_class' => Category::class,
            'class' => Category::class,
            'placeholder' => 'Seleccione una opción',
            'label' => 'Categoría del Post :',
            'attr' => array('class' => 'form-control js-example-basic-single')
        ]);
    }

    public function getBlockPrefix()
    {
        return 'post_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => "App\Entity\Post",
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }

    // this allow us to use the "add_shared" option
    public function getParent()
    {
        return Filters\SharedableFilterType::class;
    }
}