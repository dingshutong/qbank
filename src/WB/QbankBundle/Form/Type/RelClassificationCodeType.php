<?php

namespace WB\QbankBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RelClassificationCodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('classificationCodeId', 'hidden_entity', array(
                'class' => 'WB\QbankBundle\Entity\ClassificationCodes',
                'label' => false,
                'required' => false
            ))
            ->add('skipValue', 'text', array(
                'label' => false,
                'required' => false
            ));
    }

    // specify the data_class option
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\QbankBundle\Entity\QuestionsRelClassifications'
        ));
    }

    public function getName()
    {
        return 'questionsRelClassifications';
    }
}
