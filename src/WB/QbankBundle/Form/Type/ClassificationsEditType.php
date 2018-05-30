<?php

namespace WB\QbankBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClassificationsEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'textarea', array('required' => false))
            ->add('notes', 'textarea', array('required' => false))
            ->add('classificationCodes', 'collection', array(
                'type' => new ClassificationCodesType(),
                'allow_add' => true,
                'label' => false
            ))
            ->add('classificationRelCustodians', 'collection', array(
                'type' => new RelCustodiansType('classificationRelCustodians'),
                'allow_add' => true,
                'label' => 'Organizations'
            ))
            ->add('classificationRelResources', 'collection', array(
                'type' => new RelResourcesType('classificationRelResources'),
                'allow_add' => true,
                'label' => 'Resources'
            ))
            ->add('classificationRelSources', 'collection', array(
                'type' => new RelSourcesType('classificationRelSources'),
                'allow_add' => true,
                'label' => 'Sources'
            ))
            ->add('classificationRelTerms', 'collection', array(
                'type' => new RelTermsType('classificationRelTerms'),
                'allow_add' => true,
                'label' => 'Concepts'
            ))

            ->add('published', 'hidden')
            ->add('save', 'submit');
    }

    // specify the data_class option
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\QbankBundle\Entity\Classifications',
            'validation_groups' => false,
        ));
    }

    public function getName()
    {
        return 'classificationsEdit';
    }
}
