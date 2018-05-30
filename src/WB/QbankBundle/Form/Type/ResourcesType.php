<?php

namespace WB\QbankBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ResourcesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'textarea', array(
                'required'    => false,
            ))
            ->add('title', 'text', array(
                'required'    => true,
            ))
            ->add('subtitle', 'text', array(
                'required'    => false,
            ))
            ->add('creator', 'text', array(
                'required'    => false,
            ))
            ->add('alternateTitle', 'text', array(
                'label'  => 'Alternate Title',
                'required'    => false,
            ))
            ->add('publisher', 'text', array(
                'required'    => false,
            ))
            ->add('contributor', 'text', array(
                'required'    => false,
            ))
            ->add('pubDate', 'text', array(
                'required'    => false,
                'label' => 'Publication date'
            ))
            ->add('language', 'text', array(
                'required'    => false
            ))
            ->add('intIdentifier', 'text', array(
                'required'    => false,
                'label' => 'International Identifier'
            ))
            ->add('copyright', 'text', array(
                'required'    => false,
            ))
            ->add('url', 'url', array(
                'required'    => false,
                'label' => 'Location'
            ))
            ->add('docType', 'entity', array(
                "class" => 'WB\QbankBundle\Entity\DocTypes',
                'property' => 'title',
                'empty_value' => "",
                'required'    => true,
                'label' => 'Document Type'
            ))
            ->add('filename', 'file', array(
                'required'    => false,
                'data_class'    => null,
                'label' => 'File'
            ))


            ->add('published', 'hidden')
            ->add('save', 'submit');
    }

    // specify the data_class option
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\QbankBundle\Entity\Resources',
        ));
    }

    public function getName()
    {
        return 'resources';
    }
}
