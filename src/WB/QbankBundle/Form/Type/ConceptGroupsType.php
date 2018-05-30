<?php

namespace WB\QbankBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConceptGroupsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'textarea', array(
                'required'    => false,
            ))
            ->add('pid', 'hidden')
            ->add('published', 'hidden')
            ->add('save', 'submit');
    }

    // specify the data_class option
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\QbankBundle\Entity\TermGroups',
        ));
    }

    public function getName()
    {
        return 'conceptsGroup';
    }
}
