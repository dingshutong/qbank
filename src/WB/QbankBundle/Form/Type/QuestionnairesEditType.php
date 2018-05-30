<?php

namespace WB\QbankBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionnairesEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'textarea', array('required' => false))
            ->add('notes', 'textarea', array(
                'required'    => false,
            ))
            ->add('published', 'hidden')            
            ->add('save','button',array('attr'=>array('class' => 'save-questionnaire btn btn-default',
                'id' =>'save-questionnaire')));
    }

    // specify the data_class option
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\QbankBundle\DTO\QuestionnaireDTO',
            'validation_groups' => false,
        ));
    }

    public function getName()
    {
        return 'questionnaires';
    }
}
