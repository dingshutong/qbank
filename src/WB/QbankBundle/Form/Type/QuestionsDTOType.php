<?php

namespace WB\QbankBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WB\QbankBundle\Enums\QuestionVisualRepresentationFormats;

class QuestionsDTOType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'textarea', array('required' => false))
            ->add('weight', 'hidden', array('required' => false, 'label' => false))
             ;
    }

    // specify the data_class option
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\QbankBundle\DTO\QuestionnaireQuestionDTO',
        ));
    }

    public function getName()
    {
        return 'questions';
    }
}
