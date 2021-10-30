<?php
// ItemFilterType.php
namespace App\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

class CategoriaFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', Filters\TextFilterType::class);
    }

    public function getBlockPrefix()
    {
        return 'categoria_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => "App\Entity\Categoria",
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