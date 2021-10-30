<?php
// ItemFilterType.php
namespace App\Filter;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;

class EspecialistaFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('noReg', Filters\TextFilterType::class);
        $builder->add('noId', Filters\TextFilterType::class);
    }

    public function getBlockPrefix()
    {
        return 'especialista_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => "App\Entity\Especialista",
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