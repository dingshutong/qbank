<?php

namespace WB\QbankBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionnaireResourcesDTOType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => false))
            ->add('description', 'textarea', array('required' => false, 'label' => false))
            ->add('useOfLayout', 'radio', array('label' => false, 'required' => false))
            ->add('location', 'file', array('data_class' => null, 'required' => false, 'label' => false));
    }

    // specify the data_class option
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\QbankBundle\DTO\QuestionnaireResourceDTO',
        ));
    }

    public function getName()
    {
        return 'QuestionnaireResourceDTO';
    }
}
