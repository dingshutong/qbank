<?php

namespace WB\QbankBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClassificationCodesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', 'text', array('required' => false, 'label' => false))
            ->add('label', 'textarea', array('label' => false))
            ->add('description', 'textarea', array('required' => false, 'label' => false))
            ->add('weight', 'hidden', array('required' => false, 'label' => false))
            ->add('attachments', 'hidden', array('label' => false));
    }

    // specify the data_class option
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\QbankBundle\Entity\ClassificationCodes',
        ));
    }

    public function getName()
    {
        return 'classificationCodes';
    }
}
