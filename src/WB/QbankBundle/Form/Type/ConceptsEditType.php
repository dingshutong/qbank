<?php

namespace WB\QbankBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConceptsEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'textarea', array('required' => false))
            ->add('notes', 'textarea', array('required' => false))
            ->add('termRelCustodians', 'collection', array(
                'type' => new RelCustodiansType('termRelCustodians'),
                'allow_add' => true,
                'label' => 'Organizations'
            ))
            ->add('termRelResources', 'collection', array(
                'type' => new RelResourcesType('termRelResources'),
                'allow_add' => true,
                'label' => 'Resources'
            ))
            ->add('termRelSources', 'collection', array(
                'type' => new RelSourcesType('termRelSources'),
                'allow_add' => true,
                'label' => 'Sources'
            ))
            ->add('published', 'hidden')
            ->add('save', 'submit');
    }

    // specify the data_class option
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\QbankBundle\Entity\Terms',
            'validation_groups' => false,
        ));
    }

    public function getName()
    {
        return 'conceptsEdit';
    }
}
