<?php

namespace WB\QbankBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IndGrpRefType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('indGroupId', 'text');
    }

    // specify the data_class option
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\QbankBundle\Entity\IndGrpRef',
        ));
    }

    public function getName()
    {
        return 'indGrpRef';
    }
}
