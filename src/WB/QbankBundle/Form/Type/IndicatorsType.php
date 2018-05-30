<?php

namespace WB\QbankBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class IndicatorsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('indicatorAlias', 'collection', array(
                'type' => new IndicatorAliasesType(),
                'allow_add' => true,
                'allow_delete' => true,
            ))
            ->add('description', 'textarea', array(
                'required'    => false,
            ))
            ->add('unitMeasurement', 'textarea', array(
                'label'  => 'Unit of Measurement',
                'required'    => false,
            ))
            ->add('rationale', 'textarea', array(
                'required'    => false,
            ))
            ->add('limitation', 'textarea', array(
                'required'    => false,
            ))
            ->add('dataSource', 'textarea', array(
                'label'  => 'Source of Data',
                'required'    => false,
            ))
            ->add('methodology', 'textarea', array(
                'required'    => false,
            ))
            ->add('frequency', 'textarea', array(
                'required'    => false,
            ))
            ->add('dissagregation', 'textarea', array(
                'required'    => false,
            ))
            ->add('notes', 'textarea', array(
                'required'    => false,
            ))

            // more fields here ...
            
            ->add('published', 'hidden')
            ->add('save', 'submit');
    }

    // specify the data_class option
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\QbankBundle\Entity\Indicators',
            'validation_groups' => false,
        ));
    }

    public function getName()
    {
        return 'indicators';
    }
}
