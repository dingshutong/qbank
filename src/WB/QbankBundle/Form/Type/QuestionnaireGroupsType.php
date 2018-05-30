<?php

namespace WB\QbankBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionnaireGroupsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'textarea', array(
                'required'    => false,
            ))
            ->add('notes', 'textarea', array(
                'required'    => false,
            ))
            ->add('questionnaireGroupRelCustodians', 'collection', array(
                'type' => new RelCustodiansType('questionnaireGroupRelCustodians'),
                'allow_add' => true,
                'label' => 'Organizations'
            ))
            ->add('questionnaireGroupRelResources', 'collection', array(
                'type' => new RelResourcesType('questionnaireGroupRelResources'),
                'allow_add' => true,
                'label' => 'Resources'
            ))
            ->add('questionnaireGroupRelSources', 'collection', array(
                'type' => new RelSourcesType('questionnaireGroupRelSources'),
                'allow_add' => true,
                'label' => 'Sources'
            ))

            ->add('pid', 'hidden')
            ->add('published', 'hidden')
            ->add('save', 'submit');
    }

    // specify the data_class option
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\QbankBundle\Entity\QuestionnaireGroups',
        ));
    }

    public function getName()
    {
        return 'questionnaireGroupsEdit';
    }
}
