<?php

namespace WB\QbankBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RelTermsType extends AbstractType
{

    protected $dataClass;

    public function __construct($dataClass)
    {
        $this->dataClass = $dataClass;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add($builder->create('termId', 'hidden_entity', array(
                    "class" => 'WB\QbankBundle\Entity\Terms',
                    "label" => false
                ))
            )
            ->add('weight', 'hidden', array(
                'required' => false,
                "label" => false
            ));

    }

    // specify the data_class option
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\QbankBundle\Entity\\' . $this->dataClass
        ));
    }

    public function getName()
    {
        return $this->dataClass;
    }
}
