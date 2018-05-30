<?php

namespace WB\QbankBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;


class IndicatorsEditType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', 'text')
            ->add('indicatorAlias', 'collection', array(
                'type' => new IndicatorAliasesType(),
                'allow_add' => true,
                'label' => false
            ))
            ->add('description', 'textarea', array(
                'required' => false,
            ))
            ->add('unitMeasurement', 'textarea', array(
                'label' => 'Unit of Measurement',
                'required' => false,
            ))
            ->add('rationale', 'textarea', array(
                'required' => false,
            ))
            ->add('limitation', 'textarea', array(
                'required' => false,
            ))
            ->add('dataSource', 'textarea', array(
                'label' => 'Source of Data',
                'required' => false,
            ))
            ->add('methodology', 'textarea', array(
                'required' => false,
            ))
            ->add('frequency', 'textarea', array(
                'required' => false,
            ))
            ->add('dissagregation', 'textarea', array(
                'required' => false,
            ))
            ->add('notes', 'textarea', array(
                'required'    => false,
            ))
            ->add('indicatorRelCustodians', 'collection', array(
                'type' => new RelCustodiansType('indicatorRelCustodians'),
                'allow_add' => true,
                'label' => 'Organizations'
            ))
            ->add('indicatorRelResources', 'collection', array(
                'type' => new RelResourcesType('indicatorRelResources'),
                'allow_add' => true,
                'label' => 'Resources'
            ))
            ->add('indicatorRelSources', 'collection', array(
                'type' => new RelSourcesType('indicatorRelSources'),
                'allow_add' => true,
                'label' => 'Sources'
            ))
            ->add('indicatorRelClassifications', 'collection', array(
                'type' => new RelClassificationsType('indicatorRelClassifications'),
                'allow_add' => true,
                'label' => 'Classifications'
            ))

            ->add('indicatorRelTerms', 'collection', array(
                'type' => new RelTermsType('indicatorRelTerms'),
                'allow_add' => true,
                'label' => 'Concepts'
            ))

            ->add('indicatorRelModules', 'collection', array(
                'type' => new RelModulesType('indicatorRelModules'),
                'allow_add' => true,
                'label' => 'Questionnaires'
            ))

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
        return 'indicatorsEdit';
    }
}
