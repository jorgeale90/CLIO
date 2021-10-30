<?php
// ItemFilterType.php
namespace App\Filter;

use App\Entity\Categoria;
use App\Entity\TipoSitio;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;

class SitioPatrimonialFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('keyword', Filters\TextFilterType::class);

        $builder->add('codigo', Filters\TextFilterType::class);

        $builder->add('nombre', Filters\TextFilterType::class);

        $builder->add('tipositio', Filters\EntityFilterType::class, [
            'data_class' => TipoSitio::class,
            'class' => TipoSitio::class,
            'label' => 'Tipo de Sitio :',
            'attr' => array('class' => 'form-control', 'style' => 'width: 100%;')
        ]);

        $builder->add('categoria', Filters\EntityFilterType::class, [
            'data_class' => Categoria::class,
            'class' => Categoria::class,
            'label' => 'Categoría del Sitio :',
            'attr' => array('class' => 'form-control', 'style' => 'width: 100%;')
        ]);
    }

    public function getBlockPrefix()
    {
        return 'sitiopatrimonial_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => "App\Entity\SitioPatrimonial",
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}