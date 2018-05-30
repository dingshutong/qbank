<?php

namespace WB\QbankBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WB\QbankBundle\Enums\QuestionVisualRepresentationFormats;

class QuestionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'textarea', array('required' => false))
            ->add('preText', 'textarea', array('label' => 'Pre Text', 'required' => false))
            ->add('literalText', 'textarea', array('label' => 'Literal Text', 'required' => false))
            ->add('postText', 'textarea', array('label' => 'Post Text', 'required' => false))
            ->add('instructions', 'textarea', array('label' => 'Interviewer\'s instructions', 'required' => false))
            ->add('visualRepFormat', 'choice', array(
                    'label' => 'Visual Representation Format',
                    'required' => false,
                    'choices' => array(
                        0 => '--',
                        QuestionVisualRepresentationFormats::Numeric => 'Numeric',
                        QuestionVisualRepresentationFormats::Text => 'Text',
                        QuestionVisualRepresentationFormats::ClassificationList => 'Classification List'
                    ),
                    'empty_value' => false
                )
            )
            ->add('valRepFormat', 'text', array('required' => false, 'label' => false))
            ->add('notes', 'textarea', array('required' => false))
            ->add('weight', 'hidden', array('required' => false, 'label' => false))
            ->add('classificationId', 'hidden_entity', array(
                    'required' => false,
                    'label' => false,
                    'class' => 'WB\QbankBundle\Entity\Classifications',
                )
            )
            ->add('questionsRelClassifications', 'collection', array(
                'type' => new RelClassificationCodeType(),
                'label' => false,
                'required' => false
            ));
    }

    // specify the data_class option
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\QbankBundle\Entity\QuestionnaireModuleQuestions',
        ));
    }

    public function getName()
    {
        return 'questions';
    }
}
