<?php
// ItemFilterType.php
namespace App\Filter;

use App\Entity\CategoriaObjeto;
use App\Entity\SitioPatrimonial;
use App\Entity\SubTipoMaterial;
use App\Entity\TipoMaterial;
use App\Entity\UsoFuncion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;

class FichaObjetoFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('keyword', Filters\TextFilterType::class, array(
            'apply_filter' => function (QueryInterface $filterQuery, $field, $values) {
                if (empty($values['value'])) {
                    return null;
                }

                $paramName = sprintf('p_%s', str_replace('.', '_', $field));

                // expression that represent the condition
                $expression = $filterQuery->getExpr()->eq($field, ':'.$paramName);

                // expression parameters
                $parameters = array($paramName => $values['value']); // [ name => value ]
                // or if you need to define the parameter's type
                // $parameters = array($paramName => array($values['value'], \PDO::PARAM_STR)); // [ name => [value, type] ]

                return $filterQuery->createCondition($expression, $parameters);
            },
        ));

        $builder->add('codigoobjeto', Filters\TextFilterType::class);

        $builder->add('nombreobjeto', Filters\TextFilterType::class);

        $builder->add('otronombreobjeto', Filters\TextFilterType::class);

        $builder->add('categoriaobjeto', Filters\EntityFilterType::class, [
            'data_class' => CategoriaObjeto::class,
            'class' => CategoriaObjeto::class,
            'label' => 'Categoría del Sitio :',
            'attr' => array('class' => 'form-control', 'style' => 'width: 100%;')
        ]);

        $builder->add('tipomaterial', Filters\EntityFilterType::class, [
            'data_class' => TipoMaterial::class,
            'class' => TipoMaterial::class,
            'label' => 'Tipo de Material :',
            'attr' => array('class' => 'form-control', 'style' => 'width: 100%;')
        ]);

        $builder->add('subtipomaterial', Filters\EntityFilterType::class, [
            'data_class' => SubTipoMaterial::class,
            'class' => SubTipoMaterial::class,
            'label' => 'Tipo de Material :',
            'attr' => array('class' => 'form-control', 'style' => 'width: 100%;')
        ]);

        $builder->add('usofuncion', Filters\EntityFilterType::class, [
            'data_class' => UsoFuncion::class,
            'class' => UsoFuncion::class,
            'label' => 'Uso - Función :',
            'attr' => array('class' => 'form-control', 'style' => 'width: 100%;')
        ]);

        $builder->add('sitiopatrimonial', Filters\EntityFilterType::class, [
            'data_class' => SitioPatrimonial::class,
            'class' => SitioPatrimonial::class,
            'label' => 'Sitio Patrimonial :',
            'attr' => array('class' => 'form-control', 'style' => 'width: 100%;')
        ]);
    }

    public function getBlockPrefix()
    {
        return 'fichaobjetopat_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => "App\Entity\FichaObjetoPatrimonial",
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}